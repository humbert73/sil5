<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneDeCommande
 */
class LigneDeCommande
{
    /**
     * @var string
     */
    private $quantite;

    /**
     * @var string
     */
    private $price;

    /**
     * @var \sil16\VitrineBundle\Entity\Commande
     */
    private $commande;

    /**
     * @var \sil16\VitrineBundle\Entity\Article
     */
    private $article;

    /**
     * Set quantite
     *
     * @param string $quantite
     * @return LigneDeCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return string 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return LigneDeCommande
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set commande
     *
     * @param \sil16\VitrineBundle\Entity\Commande $commande
     * @return LigneDeCommande
     */
    public function setCommande(\sil16\VitrineBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \sil16\VitrineBundle\Entity\Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set article
     *
     * @param \sil16\VitrineBundle\Entity\Article $article
     * @return LigneDeCommande
     */
    public function setArticle(\sil16\VitrineBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \sil16\VitrineBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
}
