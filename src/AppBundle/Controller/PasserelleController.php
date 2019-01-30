<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Passerelle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\ResourceValidationException;  //gerer les erreurs


/**
 * Passerelle controller.
 *
 */
class PasserelleController extends Controller
{
    /**
     * Lists all passerelle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $passerelles = $em->getRepository('AppBundle:Passerelle')->findAll();

        return $this->render('AppBundle:passerelle:index.html.twig', array(
            'passerelles' => $passerelles,
        ));
    }

    /**
     * Creates a new passerelle entity.
     *
     */
    public function newAction(Request $request)
    {
        $passerelle = new Passerelle();
        $form = $this->createForm('AppBundle\Form\PasserelleType', $passerelle);
        $form->handleRequest($request);
        //set the activation date
        $creation_date = date("d-m-y");
        $passerelle->setDateCreation($creation_date);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($passerelle);
            $em->flush();

            return $this->redirectToRoute('passerelle_show', array('id' => $passerelle->getId()));
        }

        return $this->render('AppBundle:passerelle:new.html.twig', array(
            'passerelle' => $passerelle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a passerelle entity.
     *
     */
    public function showAction(Passerelle $passerelle)
    {
        $deleteForm = $this->createDeleteForm($passerelle);

        return $this->render('AppBundle:passerelle:show.html.twig', array(
            'passerelle' => $passerelle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing passerelle entity.
     *
     */
    public function editAction(Request $request, Passerelle $passerelle)
    {
        $deleteForm = $this->createDeleteForm($passerelle);
        $editForm = $this->createForm('AppBundle\Form\PasserelleType', $passerelle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('passerelle_show', array('id' => $passerelle->getId()));
        }

        return $this->render('AppBundle:passerelle:edit.html.twig', array(
            'passerelle' => $passerelle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a passerelle entity.
     *
     */
    public function deleteAction(Request $request, Passerelle $passerelle)
    {
        $form = $this->createDeleteForm($passerelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($passerelle);
            $em->flush();
        }

        return $this->redirectToRoute('passerelle_index');
    }

    /**
     * Creates a form to delete a passerelle entity.
     *
     * @param Passerelle $passerelle The passerelle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Passerelle $passerelle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('passerelle_delete', array('id' => $passerelle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
