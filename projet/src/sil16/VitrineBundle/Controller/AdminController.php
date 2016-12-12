<?php

namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Entity\Panier;
use sil16\VitrineBundle\Exception\IsNotValidQuantityException;
use sil16\VitrineBundle\Exception\IsNotValidRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class AdminController extends DefaultController
{
    public function siteAdminAction()
    {
        return $this->render('sil16VitrineBundle:Admin:siteAdmin.html.twig', array(
            'categories' => $this->getAll('Category'),
            'articles'  => $this->getAll('Article')
        ));
    }
}
