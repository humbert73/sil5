<?php
/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 02/12/16
 * Time: 13:44
 */

namespace sil16\VitrineBundle\Entity;


class Panier
{
    private $contenu;

    public function __construct()
    {
        $this->contenu = array();
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function getQuantityFromArticleId($article_id)
    {
        $quantity = 0;

        if (isset($this->contenu[$article_id])) {
            $quantity = $this->contenu[$article_id];
        }

        return $quantity;
    }

    public function ajoutArticle($article_id, $quantity = 1)
    {
        if (isset($this->contenu[$article_id])) {
            $this->contenu[$article_id] += $quantity;
        } else {
            $this->contenu[$article_id] = $quantity;
        }
    }

    public function supprimeArticle($article_id)
    {
        unset($this->contenu[$article_id]);
    }

    public function viderPanier()
    {
        unset($this->contenu);
        $this->contenu = array();
    }
}