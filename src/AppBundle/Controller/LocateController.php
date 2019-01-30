<?php

namespace AppBundle\Controller;
//call the class user
use AppBundle\Entity\User;
use AppBundle\Resources\views;
use AppBundle\Entity\Abaccount;
use AppBundle\Entity\Transactions;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocateController extends Controller
{
//display the login page
public function indexAction()  {
    return $this->render('default/index.html.twig');
}

//function to call on succefull login
function sucessfulinAction()
{    $em = $this->getDoctrine()->getManager();
    // recherche du revenue en terme de transaction
    $Abaccountrepository = $em->getRepository(Abaccount::class);
    $query = $Abaccountrepository->createQueryBuilder('b')
    ->select('SUM(b.balance)')
    ->getQuery();
    
    $balance = $query->setMaxResults(1)->getOneOrNullResult();
    //recherche du nombre total de transactions 
    $Transactionsrepository = $em->getRepository('AppBundle:Transactions');
    $transactions = $Transactionsrepository->findAll();
    $totalTransactions = count($transactions);
    //recherche des donnees pour le graph de la variation des transactions
    $rq = $em->createQuery(
        'SELECT p.dateTransfert, count(p.id) as total  
        FROM AppBundle:Transactions p where p.dateTransfert IS NOT NULL
        GROUP BY p.dateTransfert ORDER BY p.dateTransfert ASC'
    );
    
    $allTransactions  = $rq->getResult();
    return $this->render('default/home.html.twig'
    , array("revenue"=>$balance[1], 'totalTransactions'=>$totalTransactions, 'variationTransactions'=>$allTransactions));
}

}
