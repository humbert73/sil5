<?php

namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Entity\Panier;
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
                'articles'   => $this->getManagerForEntity('Article')->findAll(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

    public function articlesByCategoryAction($category_id)
    {
        return $this->render(
            'sil16VitrineBundle:Default:articlesByCategory.html.twig',
            $articles = array(
                'category'   => $this->getCategoryById($category_id)->getName(),
                'articles'   => $this->getCategoryById($category_id)->getArticles(),
                'categories' => $this->getManagerForEntity('Category')->findAll()
            )
        );
    }

//    Gestion du Panier
    public function contenuPanierAction()
    {
        $panier            = $this->getPanier();
        $total_price       = 0;
        $articles_renderer = array();
        foreach ($panier->getContenu() as $article_id => $quantity) {
            $article             = $this->getManagerForEntity('Article')->findOneById($article_id);
            $articles_renderer[] = array('article' => $article, 'quantity' => $quantity);
            $total_price += $article->getPrice() * $quantity;
        }

        return $this->render(
            'sil16VitrineBundle:Default:contenuPanier.html.twig',
            array('panier_information' => $this->getPanierInformation())
        );
    }

    public function addArticleAction($article_id)
    {
        $panier          = $this->getPanier();
        $article_libelle = $this->getManagerForEntity('Article')->findOneById($article_id)->getLibelle();

        $panier->ajoutArticle($article_id);
        $this->getSession()->set('panier', $panier);
        $this->get('session')->getFlashBag()->add(
            'info',
            "L'article $article_libelle à été ajouter au panier"
        );

        return $this->catalogueAction();
    }

    public function addArticleFromCategoryAction($article_id)
    {
        $panier          = $this->getPanier();
        $article         = $this->getManagerForEntity('Article')->findOneById($article_id);
        $article_libelle = $article->getLibelle();

        $panier->ajoutArticle($article_id);
        $this->getSession()->set('panier', $panier);
        $this->get('session')->getFlashBag()->add(
            'info',
            "L'article $article_libelle à été ajouter au panier"
        );

        return $this->articlesByCategoryAction($article->getCategory()->getId());
    }

    public function removeArticleFromPanierAction($article_id)
    {
        $this->getPanier()->supprimeArticle($article_id);
        $article_libelle = $this->getManagerForEntity('Article')->findOneById($article_id)->getLibelle();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'article $article_libelle à été retirer du panier avec succès");

        return $this->contenuPanierAction();
    }

    public function removePanierContentAction()
    {
        $this->getPanier()->viderPanier();
        $this->get('session')->getFlashBag()->add('success', 'Panier vider avec succès');

        return $this->contenuPanierAction();
    }

    public function panierInformationAction()
    {
        return $this->render(
            'sil16VitrineBundle:Default:panierInformation.html.twig',
            array('panier_information' => $this->getPanierInformation())
        );
    }

//    Méthodes du controller
    private function getPanier()
    {
        $session = $this->getSession();

        return $session->get('panier', new Panier());;
    }

    private function getPanierInformation()
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
            'total_price'    => $total_price,
            'has_contenu'    => !empty($contenue)
        );
    }

    private function getCategoryById($category_id)
    {
        return $this->getManagerForEntity('Category')->findOneById($category_id);
    }

    private function getManagerForEntity($entity_name)
    {
        return $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:'.$entity_name);
    }

    private function getSession()
    {
        return $this->getRequest()->getSession();
    }
}
