<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Abaccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abaccount controller.
 *
 */
class ABAccountController extends Controller
{
    /**
     * Lists all aBAccount entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aBAccounts = $em->getRepository('AppBundle:Abaccount')->findAll();

        return $this->render('AppBundle:abaccount:index.html.twig', array(
            'aBAccounts' => $aBAccounts,
        ));
    }

    /**
     * Creates a new aBAccount entity.
     *
     */
    public function newAction(Request $request)
    {
        $aBAccount = new Abaccount();

        $form = $this->createForm('AppBundle\Form\ABAccountType', $aBAccount);
        $form->handleRequest($request);
        // get the connected userid(from fos user)
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            // set the value in the ABaccount entity
            $aBAccount->setUser($user);
            //set the registration date
            $aBAccount->setRegistrationDate(new \DateTime(date('Y-m-d H:i:s')));
            //set the activation date
            $aBAccount->setActivationDate(new \DateTime(date('Y-m-d H:i:s')));
            // set the balance value 
            $balance =0;
            $aBAccount->setBalance($balance);
            
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aBAccount);
            $em->flush();

            return $this->redirectToRoute('abaccount_show', array('id' => $aBAccount->getId()));
        }

        return $this->render('AppBundle:abaccount:new.html.twig', array(
            'aBAccount' => $aBAccount,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a aBAccount entity.
     *
     */
    public function showAction(Abaccount $aBAccount)
    {
        $deleteForm = $this->createDeleteForm($aBAccount);

        return $this->render('AppBundle:abaccount:show.html.twig', array(
            'aBAccount' => $aBAccount,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing aBAccount entity.
     *
     */
    public function editAction(Request $request, Abaccount $aBAccount)
    {
        $deleteForm = $this->createDeleteForm($aBAccount);
        $editForm = $this->createForm('AppBundle\Form\ABAccountEditType', $aBAccount);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abaccount_show', array('id' => $aBAccount->getId()));
        }

        return $this->render('AppBundle:abaccount:edit.html.twig', array(
            'aBAccount' => $aBAccount,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a aBAccount entity.
     *
     */
    public function deleteAction(Request $request, Abaccount $aBAccount)
    {
        $form = $this->createDeleteForm($aBAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aBAccount);
            $em->flush();
        }

        return $this->redirectToRoute('abaccount_index');
    }

    /**
     * Creates a form to delete a aBAccount entity.
     *
     * @param Abaccount $aBAccount The aBAccount entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abaccount $aBAccount)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abaccount_delete', array('id' => $aBAccount->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
