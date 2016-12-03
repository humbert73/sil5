<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render(
            'sil16VitrineBundle:Default:index.html.twig',
            array('name' => $name)
        );
    }

    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }

    public function catalogueAction()
    {
        return $this->render(
            'sil16VitrineBundle:Default:catalogue.html.twig',
            $articles = array(
                'articles' => $this->getManagerForEntity('Article')->findAll(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

    public function articlesByCategoryAction($category_id)
    {
        return $this->render(
            'sil16VitrineBundle:Default:articlesByCategory.html.twig',
            $articles = array(
                'category' => $this->getCategoryById($category_id)->getName(),
                'articles' => $this->getCategoryById($category_id)->getArticles(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

    public function getCategoryById($category_id)
    {
        return $this->getManagerForEntity('Category')->findOneById($category_id);
    }

    public function getManagerForEntity($entity_name)
    {
        return $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:'.$entity_name);
    }
}
