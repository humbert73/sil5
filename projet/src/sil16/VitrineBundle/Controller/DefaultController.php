<?php

namespace sil16\VitrineBundle\Controller;

use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use sil16\VitrineBundle\Entity\Article;
use sil16\VitrineBundle\Entity\Client;
use sil16\VitrineBundle\Entity\Commande;
use sil16\VitrineBundle\Entity\LigneDeCommande;
use sil16\VitrineBundle\Entity\Panier;
use sil16\VitrineBundle\Exception\IsNotValidQuantityException;
use sil16\VitrineBundle\Exception\IsNotValidRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

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
                'articles'   => $this->getManagerForEntity('Article')->findAll(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

    public function articlesByCategoryAction($category_id)
    {
        return $this->render(
            'sil16VitrineBundle:Default:articlesByCategory.html.twig',
            array(
                'category'   => $this->getCategoryById($category_id),
                'articles'   => $this->getCategoryById($category_id)->getArticles(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

    public function articlesLesPlusVenduAction()
    {
        return $this->render(
            'sil16VitrineBundle:Default:articlesLesPlusVendu.html.twig',
            array('articles' => $this->getManagerForEntity('Article')->getTopSellingArticles())
        );
    }


//    Méthodes du controller
    protected function getPanier()
    {
        $session = $this->getSession();

        return $session->get('panier', new Panier());
    }

    protected function getPanierInformation()
    {
        $panier_articles = array();
        $total_price     = 0;
        $contenue        = $this->getPanier()->getContenu();

        foreach ($contenue as $article_id => $quantity) {
            $article           = $this->getManagerForEntity('Article')->findOneById($article_id);
            $panier_articles[] = array('article' => $article, 'quantity' => $quantity);
            $total_price += $quantity * $article->getPrice();
        }

        return array(
            'panier_articles' => $panier_articles,
            'total_price'     => $total_price,
            'has_contenu'     => !empty($contenue)
        );
    }

    private function getCategoryById($category_id)
    {
        return $this->getManagerForEntity('Category')->findOneById($category_id);
    }

    protected function getManagerForEntity($entity_name)
    {
        return $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:'.$entity_name);
    }

    private function getSession()
    {
        return $this->getRequest()->getSession();
    }

    protected function getAll($entity_name)
    {
        return $this->getManagerForEntity($entity_name)->findAll();
    }
}
