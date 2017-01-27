<?php

namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Entity\Client;
use sil16\VitrineBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{
    /**
     * Lists all client entities.
     *
     */
    public function indexAction()
    {
        $em      = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('sil16VitrineBundle:Client')->findAll();
        $forms   = array();

        foreach ($clients as $client) {
            $deleteForm = $this->createDeleteForm($client);
            $forms[]    = $deleteForm->createView();
        }

        return $this->render('client/index.html.twig', array(
            'clients'      => $clients,
            'delete_forms' => $forms
        ));
    }

    /**
     * Creates a new client entity.
     *
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $form   = $this->createForm(new ClientType(), $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->persist($client);
            $em->flush($client);
            $request->getSession()->set('client_id', $client->getId());

            return $this->redirectToRoute('catalogue');
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client'      => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm   = $this->createForm(new ClientType(), $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $em      = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->persist($client);
            $em->flush($client);
            $request->getSession()->set('client_id', $client->getId());

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client'      => $client,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     */
    public function deleteAction(Request $request, Client $client)
    {
        $form = $this->createDeleteForm($client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush($client);
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function profilAction(Request $request, Client $client)
    {
        $editForm = $this->createFormBuilder($client)
            ->add('nom', null, array('label' => 'Nom', 'data' => $client->getNom()))
            ->add('mail', "email", array('label' => 'Adresse email', 'data' => $client->getMail()))
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Votre profil à bien été mis à jour');

            return $this->redirectToRoute('client_profil', array('id' => $client->getId()));
        }

        return $this->render('client/profil.html.twig', array(
            'client'    => $client,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function passwordAction(Request $request, Client $client)
    {
        $passwordForm = $this->createFormBuilder($client)
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent correspondre.',
                'options'         => array('attr' => array('class' => 'password-field')),
                'required'        => true,
                'first_options'   => array('label' => 'Mot de passe'),
                'second_options'  => array('label' => 'Confirmez votre mot de passe'),
            ))
            ->getForm();
        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && ! $passwordForm->isValid()) {
            $request->getSession()->getFlashBag()->add('danger', 'Les deux mot de passe ne corresponde pas');
        }
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $em->persist($client);
            $em->flush($client);
            $request->getSession()->set('client_id', $client->getId());
            $request->getSession()->getFlashBag()->add('success', 'Votre mot de passe à bien été mis à jour');

            return $this->redirectToRoute('client_profil', array('id' => $client->getId()));
        }

        return $this->render('client/password.html.twig', array(
            'client'        => $client,
            'password_form' => $passwordForm->createView(),
        ));
    }
}
