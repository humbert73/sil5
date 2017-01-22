<?php

namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('sil16VitrineBundle:Commande')->findAll();
        $forms     = array();

        foreach ($commandes as $commande) {
            $deleteForm = $this->createDeleteForm($commande);
            $forms[]    = $deleteForm->createView();
        }

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
            'delete_forms' => $forms
        ));
    }

    /**
     * Creates a new commande entity.
     *
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('sil16\VitrineBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush($commande);

            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createFormBuilder($commande)
            ->add('etat', CheckboxType::class, array('required' => false))
            ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush($commande);
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function indexClientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($user = $this->getUser()) {
            $client_id = $user->getId();
            $client = $em->getRepository('sil16VitrineBundle:Client')->findOneById($client_id);
            $commandes = $em->getRepository('sil16VitrineBundle:Commande')->findBy(array('client' => $client));
            $prices = array();

            foreach ($commandes as $commande) {
                $prices[] = $commande->getPrice();
            }

            return $this->render('commande/indexClient.html.twig', array(
                'commandes' => $commandes,
                'client_id' => $client_id,
                'prices'    => $prices
            ));
        } else {
            $request->getSession()->getFlashBag()->add('warning','Vous n\'avez aucune commande pour le moment');

            return $this->redirectToRoute('accueil');
        }
    }
}
