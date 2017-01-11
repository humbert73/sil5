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

class PanierController extends DefaultController
{
    public function contenuPanierAction(Request $request)
    {
        $panier            = $this->getPanier($request);
        $total_price       = 0;
        $articles_renderer = array();
        foreach ($panier->getContenu() as $article_id => $quantity) {
            $article             = $this->getManagerForEntity('Article')->findOneById($article_id);
            $articles_renderer[] = array('article' => $article, 'quantity' => $quantity);
            $total_price += $article->getPrice() * $quantity;
        }

        return $this->render(
            'sil16VitrineBundle:Default:contenuPanier.html.twig',
            array('panier_information' => $this->getPanierInformation($request))
        );
    }

    public function addArticleAction(Request $request, $article_id)
    {
        try {
            $this->addArticle($request, $article_id);
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

    private function addArticle(Request $request, $article_id)
    {
        $quantity             = $request->get('quantity');
        $stock                = $request->get('stock');
        $panier               = $this->getPanier($request);
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
        $request->getSession()->set('panier', $panier);
        $request->getSession()->getFlashBag()->add(
            'info',
            "L'article $article_libelle à été ajouter au panier"
        );
    }

    public function removeArticleFromPanierAction(Request $request, $article_id)
    {
        $this->getPanier($request)->supprimeArticle($article_id);
        $article_libelle = $this->getManagerForEntity('Article')->findOneById($article_id)->getLibelle();
        $this->get('session')->getFlashBag()->add(
            'success',
            "L'article $article_libelle à été retirer du panier avec succès");

        return $this->contenuPanierAction($request);
    }

    public function removePanierContentAction(Request $request)
    {
        $this->getPanier($request)->viderPanier();
        $this->get('session')->getFlashBag()->add('success', 'Panier vider avec succès');

        return $this->contenuPanierAction($request);
    }

    public function panierInformationAction(Request $request)
    {
        return $this->render(
            'sil16VitrineBundle:Default:panierInformation.html.twig',
            array('panier_information' => $this->getPanierInformation($request))
        );
    }

    public function validerPanierAction(Request $request)
    {
        $panier = $this->getPanier($request);
        $em     = $this->getDoctrine()->getManager();

        if (! $user = $this->getUser()) {
            $request->getSession()->getFlashBag()->add('danger', 'Vous devez être connecté pour valider une commande');

            return $this->contenuPanierAction($request);
        } elseif ( empty($panier->getContenu()) ) {
            $request->getSession()->getFlashBag()->add('warning', 'Votre panier est vide');

            return $this->contenuPanierAction($request);
        } else {
            $client   = $this->getManagerForEntity('Client')->findOneById($user->getId());
            $commande = $this->buildCommande($em, $client);

            foreach ($panier->getContenu() as $article_id => $quantity) {
                $article = $this->getManagerForEntity('Article')->findOneById($article_id);
                $commande->addLigneDeCommande($this->buildLigneDeCommande($em, $article, $quantity, $commande));
            }
            $em->flush($commande);
            $this->getPanier($request)->viderPanier();
            $request->getSession()->getFlashBag()->add('success', 'Panier validé avec succès');
        }

        return $this->catalogueAction($request);
    }

    private function buildCommande(EntityManager $em, Client $client)
    {
        $commande = new Commande();

        $commande->setClient($client);
        $commande->setDate(new DateTime());
        $commande->setEtat(0);
        $em->persist($commande);
        $em->flush($commande);

        return $commande;
    }

    private function buildLigneDeCommande(EntityManager $em, Article $article, $quantity, Commande $commande)
    {
        $ligne_de_commande = new LigneDeCommande();
        $this->updateStock($em, $article, $quantity);

        $ligne_de_commande->setArticle($article);
        $ligne_de_commande->setPrice($article->getPrice() * $quantity);
        $ligne_de_commande->setQuantite($quantity);
        $ligne_de_commande->setCommande($commande);
        $em->persist($ligne_de_commande);
        $em->flush($ligne_de_commande);

        return $ligne_de_commande;
    }

    private function updateStock(EntityManager $em, Article $article, $quantity)
    {
        $article->setStock($article->getStock()-$quantity);
        $em->persist($article);
        $em->flush($article);
    }
}
