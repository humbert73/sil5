<?php

namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Entity\Panier;
use sil16\VitrineBundle\Exception\IsNotValidQuantityException;
use sil16\VitrineBundle\Exception\IsNotValidRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

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
            array('articles' => $this->getTopSellingArticles())
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
        try {
            $this->addArticle($article_id);
        } catch (IsNotValidRequestException $exception) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                "La requête n'est pas valide"
            );
        } catch (IsNotValidQuantityException $exception) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                "La quantité doit être comprise entre 1 et la limite du stock"
            );
        }

        return $this->catalogueAction();
    }

    public function addArticleFromCategoryAction($article_id)
    {
        try {
            $this->addArticle($article_id);
        } catch (IsNotValidRequestException $exception) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                "La requête n'est pas valide"
            );
        } catch (IsNotValidQuantityException $exception) {
            $this->get('session')->getFlashBag()->add(
                'danger',
                "La quantité doit être supérieur à 1 et dans la limite du stock"
            );
        }

        return $this->articlesByCategoryAction($this->get('request')->get('category_id'));
    }

    private function addArticle($article_id)
    {
        $quantity             = $this->get('request')->get('quantity');
        $stock                = $this->get('request')->get('stock');
        $panier               = $this->getPanier();
        $quantity_from_panier = $panier->getQuantityFromArticleId($article_id);
        $article              = $this->getManagerForEntity('Article')->findOneById($article_id);
        $article_libelle      = $article->getLibelle();

        if ($quantity === null || $stock === null) {
            throw new IsNotValidRequestException();
        }
        if ($quantity < 1 || $quantity + $quantity_from_panier > $stock) {
            throw new IsNotValidQuantityException();
        }


        $panier->ajoutArticle($article_id, $quantity);
        $this->getSession()->set('panier', $panier);
        $this->get('session')->getFlashBag()->add(
            'info',
            "L'article $article_libelle à été ajouter au panier"
        );
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
            'total_price'     => $total_price,
            'has_contenu'     => !empty($contenue)
        );
    }

    private function getTopSellingArticles()
    {
        $articles = $this->getManagerForEntity('Article')->findAll();

        return array($articles[1], $articles[2], $articles[3]);
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
