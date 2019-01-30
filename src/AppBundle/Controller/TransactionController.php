<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Transactions;
use AppBundle\Entity\Transactiondetails;
use AppBundle\Entity\Passerelle;
use AppBundle\Entity\Abaccount;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use AppBundle\StandaloneCache\StandaloneCache;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;


/**
 * @Rest\Route("/transaction")
 * @Rest\RouteResource("Transaction")
 */
class TransactionController extends FOSRestController
{
	/**
     * @Rest\Post(
     * path = "/bill"
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Effectue une transaction",
     * ),
     * @SWG\Parameter(
     *    name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="Authorization"
     * ),
     * @SWG\Parameter(
     *    name="content-Type",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="content-Type",
     *     default="application/json"
     * ),
     * @SWG\Parameter(
     *    name="accept",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="accept",
     *     default="application/json"
     * ), 
     * @SWG\Parameter(
     *    name="accept-Encoding",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="accept-Encoding",
     *     default="deflate"
     * ),         
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="info sur la commande",
     *     type="object",
     *     @SWG\Schema(
     *     type="object",
     *      @SWG\Property(
     *         type="object",   
     *         property="order",
     *         @SWG\Items(
     *            type="object",
     *            @SWG\Property(property="reference", type="string"),
     *            @SWG\Property(property="redirectUrl", type="string"),
     *         ),    
     *       ),
     *       @SWG\Property(
     *          type="object",
     *          property="amount",
     *          @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="amountTTC", type="float"),
     *             @SWG\Property(property="currency", type="string"),
     *             @SWG\Property(property="paymentMethod", type="string"),
     *          ),
     *       ), 
     *       @SWG\Property(
     *          type="object",
     *          property="buyer",
     *          @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="'msisdn", type="string"),
     *              @SWG\Property(property="operateur", type="string"),
     *              @SWG\Property(property="name", type="string"),
     *               @SWG\Property(property="email", type="string"),
     *          ),
     *       ), 
     *      ),
     * )
     * * @Rest\View(statusCode = Response::HTTP_OK)
     */
	function billAction(Request $request, LoggerInterface $logger)
    {   // get each element of the associative array
        // get information sur la commande
        $logger = $this->get('logger');
        $logger->info('JSON input ==>'.$request->getContent());
        $data = json_decode($request->getContent(),true);
        //extract header Authorization value
        $each_group = $this->extractHeader($request); 
        //verify if merchant account exists
        $consummer_details=$this->verifierCompteMarchant($each_group);
        if($consummer_details==null)
            return $this->errorResponse("DEF-1","Compte Marchand inexistant ou inactif."); 
        //verify the access authorization
        $authorization=$this->authentication($each_group,$consummer_details);
        if(!$authorization)
            return $this->errorResponse("DEF-2","Accès non autorisé."); 
        //verify json required fields
        $required=$this->requiredFields($data);
        if(!$required)
            return $this->errorResponse("DEF-3","Paramètres obligatoires non fournis ou invalides dans le corps de la requete."); 
                
            
                $orderId = $data['order']['reference'];
                $redirectUrl = $data['order']['redirectUrl'];
                // get information sur la montant
                $amountTtc = $data['amount']['amountTTC'];
                $currency = $data['amount']['currency'];
                $paymentMethod = $data['amount']['paymentMethod'];
                // get les informations sur le buyer
                $msisdnSender = $data['buyer']['msisdn'];
                $operateur = $data['buyer']['operateur'];
                $customerName = $data['buyer']['name'];
                $emailSender = $data['buyer']['email'];  

                
                /* si la validation, l'authorization et la verification du compte marchant se sont bien passes 
                appelons la fonction pour verifier l'existence d'une passerelle
                */
                $verificationPasserelle = $this->verifierPasserelleExistente($msisdnSender);
                if($verificationPasserelle == null)
                    return $this->errorResponse("DEF-4","Aucune passerelle trouvée pour le payment");

                    
                        $transactions = new Transactions();
                        //explode $verificationPasserelle en array pour pouvoir get le Id et le msisdn de la passerelle trouvee
                        $passerelleTrouve = explode(" ", $verificationPasserelle);
                        $passerelle = new Passerelle();
                        //set la clee etrangere passerelle_id dans transaction entity venant de passerelle entity 
                        $repository = $this->getDoctrine()->getRepository(Passerelle::class);
                        // id en object
                        $passerelle_id = $repository->findOneByid($passerelleTrouve[0]);
                        //set la clee etrangere venant de passerelle
                        $transactions ->setPasserelle($passerelle_id);
                        $msisdnRecipient =$passerelle_id->getMsisdn();
                        $transactions->setMsisdnRecipient($msisdnRecipient); 
                        $transactions->setEmailRecipient($consummer_details->getEmail());
                        $transactions->setState("PENDING");
                        $transactions->setCountryCode(substr($msisdnSender,0,5));
                        $transactions->setTotalAmountReceived(0);
                        $transactions->setDeltaAmount(0);
                        //set la clee etrangere venant de abaccount entity
                        $transactions ->setAbaccount($consummer_details);
                        // set all transactions informations send by the client
                        $transactions->setCustomerName($customerName);
                        $transactions->setMsisdnSender(substr($msisdnSender,5,strlen($msisdnSender)));
                        $transactions->setOrderId($orderId);
                        $transactions->setRedirectUrl($redirectUrl);
                        $transactions->setAmountTTC($amountTtc);
                        $transactions->setTypeOperation($paymentMethod);
                        $transactions->setCurrency($currency);
                        $transactions->setEmailSender($emailSender);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($transactions);
                        $em->flush();

                        // mettre a jour la table TransactionsDetails apres la transaction effectuer
                        $transactionsdetails = new Transactiondetails();
                        // gerer la clee etrangere venant de l'entity transactiondetails
                        $transactionsdetails->setTransaction($transactions);
                        $operation_date =new \DateTime(date('Y-m-d H:i:s'));
                        $transactionsdetails-> setOperationDate($operation_date);
                        $transactionsdetails-> setPayementMethod($paymentMethod);
                        $transactionsdetails-> setTotalAmountReceived(0);
                        $transactionsdetails->setTransactionState("PENDING");
                        $transactionsdetails->setMsisdnSender(substr($msisdnSender,5,strlen($msisdnSender)));
                        $transactionsdetails->setMsisdnReceiver($msisdnRecipient);
                        $transactionsdetails->setCurrency($currency);
                        $transactionsdetails->setCountryCode(substr($msisdnSender,0,5));
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($transactionsdetails);
                        $em->flush();

                        //faire appel a l'object cache
                        StandaloneCache::writeInCache($msisdnSender,$transactions->getId());
                        $logger->info('Transaction cache value '.$msisdnSender.' ==>'.StandaloneCache::getCache($msisdnSender));
                        // recuperer les variables d'entetes pour gerer l'url
                        //hostname
                        $hostname = $request->server->get('HTTP_HOST');
                        //http
                        $tab=explode('/',$request->server->get('SERVER_PROTOCOL'));
                        $protocol=strtolower($tab[0]);
                        return new JsonResponse(["codeRetour"=>"OK", "reference"=>$orderId, "status"=>"PENDING", "statusUrl"=>"{$protocol}://{$hostname}/ws/transaction/{$transactions->getId()}/status", "GateWay"=>["msisdn"=>$passerelleTrouve[1], "operateur"=>$operateur]],Response::HTTP_OK);
                   
    }
    
    function extractHeader(Request $request){
        // get each parameter in the authorization header
        $authorization = $request->headers->get('Authorization');
        $each_group = explode('"', $authorization);

        return $each_group;
    }

    function verifierCompteMarchant(array $each_group){
        $repository = $this->getDoctrine()->getRepository(Abaccount::class);
        // find a single marchant base on his email
        $consummer_details = $repository->findOneByemail($each_group[1]);
        if(!$consummer_details)    {
            return null;
        }

        return $consummer_details;
    }

    function authentication(array $each_group,$consummer_details){
        $ConsumerEmail = $each_group[1];
        $consumerToken = $each_group[5];
        $consumerName = $each_group[7];
        $consumerTimestamp = $each_group[3];
        
        $consumerSecret = $consummer_details->getCosumerSecret();
        $id = $consummer_details->getId();
        // concatenation des champs
        $consummerTokenIn = md5($id.$consumerTimestamp.$consumerSecret);
       
        //verifier si le client est autoriser a utiliser l'API
        if($consummerTokenIn == $consumerToken) {
            return true;
        }
        
        return false;
    }

    function requiredFields(array $data){
        if(!array_key_exists("order", $data) || !array_key_exists("amount", $data) || !array_key_exists("buyer", $data))
            return false;

        if(!isset($data["order"]["reference"]) || !isset($data["order"]["redirectUrl"]) || !isset($data["amount"]["amountTTC"])
            || !isset($data["amount"]["currency"]) || !isset($data["amount"]["paymentMethod"]) || !isset($data["buyer"]["msisdn"])
            || !isset($data["buyer"]["operateur"]))
            return false;
        
        if($data["order"]["reference"]==null || $data["order"]["redirectUrl"]== null || $data["amount"]["amountTTC"]==null 
            || $data["amount"]["currency"]==null || $data["amount"]["paymentMethod"]==null || $data["buyer"]["msisdn"]==null 
            || $data["buyer"]["operateur"]==null)
            return false;
        return true;
    }


    // verifier le status de la transaction
        /**
         * @Rest\Get(
         * path = "/{id}/status")
         *  @SWG\Response(
         *     response=200,
         *     description="Verifier status d'une transaction",
         *  )
         */

    function transactionStatus($id)        {
        
        $id =$id;
        // get le status de la transaction
        $repository = $this->getDoctrine()->getRepository(Transactions::class);
        // find status base on the transaction Id
        $transaction_state = $repository->findOneById($id);
        if($transaction_state)
            return new JsonResponse(["codeRetour"=>"OK","status"=>$transaction_state->getState()],Response::HTTP_OK);
        else  
            return $this->errorResponse("DEF-5","Transaction Inexistante.");
    }

    // verifier l'existence d'une passerelle
        /**
         * @Rest\Get(
         * path = "/{operateur}/{msisdn}/passerelle")
         *   @SWG\Response(
         *     response=200,
         *     description="Verifier passerelle existente",
         *   )
         */

        function verifierPasserelle($msisdn, $operateur)       {
            $passerelleExistente = $this->verifierPasserelleExistente($msisdn);
            if($passerelleExistente == null)    
                return $this->errorResponse("DEF-4","Aucune passerelle trouvee pour le payment.");
            
            else 
                $passerelleTrouve = explode(" ", $passerelleExistente);
                return new JsonResponse(["codeRetour"=>"OK", "Gateway"=>["msisdn"=>$passerelleTrouve[1], "operateur"=>$operateur]],Response::HTTP_OK);
            
            
        }



        function verifierPasserelleExistente($msisdnClient)   {
            //retirer le 00237 sur le msisdn client avant de verifier l'existence d'une passerelle
            $msisdnClient = ltrim($msisdnClient, substr($msisdnClient,0,5));
            $em = $this->getDoctrine()->getManager();
            $passerelles = $em->getRepository('AppBundle:Passerelle')->findAll();
            // louper sur chaque expression reguliere pour verifier si il ya celle qui correspond au numero fourni par le client
            foreach($passerelles as $row)    { 
                $ExpressionReguliere = $row->getRegularExpression();
                if(preg_match($ExpressionReguliere, $msisdnClient)) {
                    return $row->getId()." ".$row->getMsisdn();
                    break;
                }
            }
            return null;

        }

        function errorResponse($code,$description)   {
            return new JsonResponse(["codeRetour"=>"NOK","Error"=>$code,"Description"=>$description],Response::HTTP_BAD_REQUEST);
        }

}

?>