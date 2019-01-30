<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transactions;
use AppBundle\Entity\Transactiondetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Transaction controller.
 *
 */
class PaymentController extends Controller
{
    /**
     * Lists all transaction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('AppBundle:Transactions')->findAll();

        return $this->render('AppBundle:transactions:index.html.twig', array(
            'transactions' => $transactions,
        ));
    }

    /**
     * Finds and displays transactiondetails entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $transactiondetails = $em->getRepository('AppBundle:Transactiondetails')->findBytransaction($id);

        return $this->render('AppBundle:transactions:show.html.twig', array(
            'Transactiondetails' => $transactiondetails,
            'id'=> $id,
        ));
    }

    /**
     * Displays a form to edit an existing transactions entity.
     *
     */
    public function editAction(Request $request, Transactions $transactions)
    {
        $editForm = $this->createForm('AppBundle\Form\TransactionsEditType', $transactions);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transactions_index');
        }

        return $this->render('AppBundle:transactions:edit.html.twig', array(
            'transactions' => $transactions,
            'edit_form' => $editForm->createView(),
        ));
    }

}
