<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommandDetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commanddetail controller.
 *
 */
class CommandDetailsController extends Controller
{
    /**
     * Lists all commandDetail entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandDetails = $em->getRepository('AppBundle:CommandDetails')->findAll();

        return $this->render('commanddetails/index.html.twig', array(
            'commandDetails' => $commandDetails,
        ));
    }

    /**
     * Creates a new commandDetail entity.
     *
     */
    public function newAction(Request $request)
    {
        $commandDetail = new CommandDetails();
        $form = $this->createForm('AppBundle\Form\CommandDetailsType', $commandDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandDetail);
            $em->flush();

            return $this->redirectToRoute('commanddetails_show', array('id' => $commandDetail->getId()));
        }

        return $this->render('commanddetails/new.html.twig', array(
            'commandDetail' => $commandDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commandDetail entity.
     *
     */
    public function showAction(CommandDetails $commandDetail)
    {
        $deleteForm = $this->createDeleteForm($commandDetail);

        return $this->render('commanddetails/show.html.twig', array(
            'commandDetail' => $commandDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commandDetail entity.
     *
     */
    public function editAction(Request $request, CommandDetails $commandDetail)
    {
        $deleteForm = $this->createDeleteForm($commandDetail);
        $editForm = $this->createForm('AppBundle\Form\CommandDetailsType', $commandDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commanddetails_edit', array('id' => $commandDetail->getId()));
        }

        return $this->render('commanddetails/edit.html.twig', array(
            'commandDetail' => $commandDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commandDetail entity.
     *
     */
    public function deleteAction(Request $request, CommandDetails $commandDetail)
    {
        $form = $this->createDeleteForm($commandDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commandDetail);
            $em->flush();
        }

        return $this->redirectToRoute('commanddetails_index');
    }

    /**
     * Creates a form to delete a commandDetail entity.
     *
     * @param CommandDetails $commandDetail The commandDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommandDetails $commandDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commanddetails_delete', array('id' => $commandDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
