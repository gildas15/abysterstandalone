<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Transactions;
use AppBundle\Entity\Abaccount;
use AppBundle\Entity\Transactiondetails;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\StandaloneCache\StandaloneCache;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;


/**
 * @Rest\Route("/MobileMoney")
 * @Rest\RouteResource("MobileMoney")
 */
class MobileMoneyController extends FOSRestController
{
	/**
	 * @Rest\Get(
	 * path = "/transfert"
	 * )
     * @SWG\Response(
     * response=200,
     * description="Effectuer un payment mobile money",
     * ),
     * @SWG\Parameter(
     *    name="amountTTC",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="Payed amount"
     * ),
     * @SWG\Parameter(
     *    name="amount",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="current amount in account"
     * ),
     *  @SWG\Parameter(
     *    name="fee",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="cout de la transaction"
     * ),
     *  @SWG\Parameter(
     *    name="countryCode",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="country code"
     * ),
     * @SWG\Parameter(
     *    name="msisdnReceiver",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="receiver msisdn"
     * ),
     *  @SWG\Parameter(
     *    name="msisdnSender",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="sender msisdn"
     * ),
     * * @SWG\Parameter(
     *    name="currency",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="currency"
     * ),
     * * @SWG\Parameter(
     *    name="operatorTransactionId",
     *     required=true,
     *     in="query",
     *     type="string",
     *     description="operatorTransactionId"
     * )
	 * * @Rest\View(statusCode = Response::HTTP_OK)
     * @Rest\QueryParam(name="amountTTC")
     * @Rest\QueryParam(name="amount")
     * @Rest\QueryParam(name="fee")
     * @Rest\QueryParam(name="countryCode")
     * @Rest\QueryParam(name="msisdnReceiver")
     * @Rest\QueryParam(name="msisdnSender")
     * @Rest\QueryParam(name="currency")
     * @Rest\QueryParam(name="operatorTransactionId")
	 */
	
    function transfertAction(ParamFetcherInterface $paramFetcher, \Swift_Mailer $mailer)
	{
        $logger = $this->get('logger');
        //verify all required parameters
        $required=$this->requiredFields($paramFetcher);
        if (!$required)
            return $this->errorResponse("DEF-3", "tout les attributs sont obligatoires");            

        //get les parametres envoyer par la methode GET
        $amountTTC_mobileMoney = $paramFetcher->get('amountTTC');
        $amount = $paramFetcher->get('amount');
        $fee = $paramFetcher->get('fee');
        $countryCode = $paramFetcher->get('countryCode');
        $msisdnReceiver = $paramFetcher->get('msisdnReceiver');
        $msisdnSender = $paramFetcher->get('msisdnSender');
        $currency = $paramFetcher->get('currency');
        $OperatorTransactionId = $paramFetcher->get('operatorTransactionId');
        //get transaction cache value
        $logger->info('msisdn sender ==>'.$countryCode.$msisdnSender);
        $transactionId=StandaloneCache::getCache($countryCode.$msisdnSender);
        $logger->info('Transaction cache value '.$msisdnSender.' ==>'.StandaloneCache::getCache($countryCode.$msisdnSender));
        //$logger->info('after removing transaction cache value '.$msisdnSender.' ==>'.StandaloneCache::getCache($countryCode.$msisdnSender));
         
        if($transactionId!=null)    {
            // recuperer le record de la transaction correspondante 
            $repository = $this->getDoctrine()->getRepository(Transactions::class);
            $transaction = $repository->findOneById($transactionId);
            //get le montant deja payer
            $toPay=$transaction->getAmountTTC();
            $received = $amountTTC_mobileMoney+$transaction->getTotalAmountReceived();
            $deltaAmount = $toPay - $received;
            if($deltaAmount<0)$deltaAmount=0;
            if($transaction->getState()=='PENDING' || $transaction->getState()=='INCOMPLETE'){
                $transaction->setTotalAmountReceived($received);
                $transaction->setDeltaAmount($deltaAmount);
                $transaction->setDateTransfert(new \DateTime(date('Y-m-d H:i:s')));
                $transaction->setDateReceptionSMS(new \DateTime(date('Y-m-d H:i:s')));
                $transaction->setFees($fee);
                if($received>=$toPay){ //payment complete
                    $logger->info('Transaction DONE '.$transaction->getId());
                    $transaction->setState('DONE');
                    //notify merchant by email
                    $this->notifyByEmail($mailer, $transaction, $amountTTC_mobileMoney);
                }else{
                    $logger->info('Transaction INCOMPLETE '.$transaction->getId());
                    $transaction->setState('INCOMPLETE');
                    //notify merchant by email
                    $this->notifyByEmail($mailer, $transaction, $amountTTC_mobileMoney);
                    //notify customer by SMS
                    $this->notifyCustomerBySms($transaction,$msisdnReceiver, $amountTTC_mobileMoney);
                }
                //update transaction object
                $em = $this->getDoctrine()->getManager();
                $em->persist($transaction);
                $em->flush();
                //update merchant account balance
                $this->modifierleCompteMarchant($transaction,$amountTTC_mobileMoney);
                // update la table transaction details
                $this->updateTransactionDetails($transaction);

                if($transaction->getState()=='DONE'){
                    //remove transaction in cache
                    StandaloneCache::removeInCache($countryCode.$msisdnSender);
                    //redirect to customer website
                    $this->redirectToSiteMarchant($transaction);
                }
            }
        }else{
            $logger->info('Aucune transaction dans le cache pour ce numéro :'.$countryCode.$msisdnSender);
            return $this->errorResponse("DEF-6","Aucune transaction dans le cache pour ce numéro:".$countryCode.$msisdnSender); 
        }
            
    }
    
    function requiredFields(ParamFetcherInterface $paramFetcher) {
        if($paramFetcher->get('amountTTC')==null || $paramFetcher->get('amount')==null || $paramFetcher->get('fee')==null
        || $paramFetcher->get('msisdnReceiver')==null || $paramFetcher->get('msisdnSender')==null || $paramFetcher->get('currency')==null
        || $paramFetcher->get('operatorTransactionId')==null || $paramFetcher->get('countryCode')==null)
        return false;

        return true;
    }

   function updateTransactionDetails($transaction)    {
        //update la table transaction
        $transactionsdetails = new Transactiondetails();
        $transactionsdetails->setTransaction($transaction);
        $transactionsdetails->setOperationDate($transaction->getDateTransfert());
        $transactionsdetails->setPayementMethod($transaction->getTypeOperation());
        $transactionsdetails->setTotalAmountReceived($transaction->getTotalAmountReceived());
        $transactionsdetails->setTransactionState($transaction->getState());
        $transactionsdetails->setMsisdnSender($transaction->getMsisdnSender());
        $transactionsdetails->setMsisdnReceiver($transaction->getMsisdnRecipient());
        $transactionsdetails->setCurrency($transaction->getCurrency());
        $transactionsdetails->setCountryCode($transaction->getCountryCode());
        $em = $this->getDoctrine()->getManager();
        $em->persist($transactionsdetails);
        $em->flush();
   }

    function modifierleCompteMarchant($transaction, $amountAlreadyPayed)     {
        $abaccount = $transaction->getAbaccount();
        $abaccount->setBalance($abaccount->getBalance()+$amountAlreadyPayed);
        $em = $this->getDoctrine()->getManager();
        $em->persist($abaccount);
        $em->flush();
    }

    function  redirectToSiteMarchant($transaction)      {
        $handle = curl_init();
        $reference = $transaction->getOrderId();
        $state = $transaction->getState();
        $redirectUrl = $transaction->getRedirectUrl()."?reference=".$reference.'&status='.$state;
        curl_setopt($handle, CURLOPT_URL, $redirectUrl);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($handle);

    }

    function notifyByEmail($mailer, $transaction, $amountTTC_mobileMoney)    {
        $abaccount = $transaction->getAbaccount();
        $date = date('d-M-y H:i:s');
        $message = (new \Swift_Message('Hello '.$abaccount->getEmail()))
        ->setFrom($transaction->getEmailSender())
        ->setTo($abaccount->getEmail())
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/notifyMerchant.html.twig
                'Emails/notifyMerchant.html.twig',
                array('transaction'=>$transaction, 'montantPayer'=> $amountTTC_mobileMoney, 'date'=>$date)
            ),
            'text/html'
        )
        ;

        $this->get('mailer')->send($message);

    }

    function notifyCustomerBySms($transaction, $msisdnReceiver, $amountTTC_mobileMoney)      {
    $uri_cont = 'http://api.wasamundi.com/v2/texto/';
     // api key and user
     $api_key ="GZUQFfo6";
     $user ="abyster";
     $from = "ABysterInc";
     $to = $transaction->getCountryCode().$transaction->getMsisdnSender();
     // Build the post data
        $msg=$transaction->getCustomerName().",votre payment de ".$amountTTC_mobileMoney." ".$transaction->getCurrency().
        " de la commande ".$transaction->getOrderId()." sur ".$msisdnReceiver." est incomplet.reste a payer ".$transaction->getDeltaAmount()." ".$transaction->getCurrency();
        $msg = urlencode($msg);
	    $post = $uri_cont."send_sms?api_key=".$api_key."&user=".$user."&from=".$from."&to=".$to."&msg=".$msg;
	    return $this->curl($post);

    }

    function curl($post){
		//Initialize the cURL session
		$data = curl_init();
		//Set the URL
		curl_setopt($data, CURLOPT_URL, $post);		
		//Ask cURL to return the contents in a variable 
		//instead of simply echoing them to  the browser.
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		//Execute the cURL session
		$notice = curl_exec ($data);
		//Close cURL session
		curl_close ($data);
		return $notice;
	}



    function errorResponse($code,$description)   {
        return new JsonResponse(["codeRetour"=>"NOK","Error"=>$code,"Description"=>$description],Response::HTTP_BAD_REQUEST);
    }

}

?>