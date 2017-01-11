<?php

namespace sil16\VitrineBundle\Controller;

class SecurityController extends DefaultController
{
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('sil16VitrineBundle:Security:login.html.twig', array(
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
        ));
    }
}
