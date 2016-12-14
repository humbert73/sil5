<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 */
class Article
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneDeCommande;

    /**
     * @var \sil16\VitrineBundle\Entity\Category
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ligneDeCommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Article
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add ligneDeCommande
     *
     * @param \sil16\VitrineBundle\Entity\LigneDeCommande $ligneDeCommande
     * @return Article
     */
    public function addLigneDeCommande(\sil16\VitrineBundle\Entity\LigneDeCommande $ligneDeCommande)
    {
        $this->ligneDeCommande[] = $ligneDeCommande;

        return $this;
    }

    /**
     * Remove ligneDeCommande
     *
     * @param \sil16\VitrineBundle\Entity\LigneDeCommande $ligneDeCommande
     */
    public function removeLigneDeCommande(\sil16\VitrineBundle\Entity\LigneDeCommande $ligneDeCommande)
    {
        $this->ligneDeCommande->removeElement($ligneDeCommande);
    }

    /**
     * Get ligneDeCommande
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLigneDeCommande()
    {
        return $this->ligneDeCommande;
    }

    /**
     * Set category
     *
     * @param \sil16\VitrineBundle\Entity\Category $category
     * @return Article
     */
    public function setCategory(\sil16\VitrineBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \sil16\VitrineBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var integer
     */
    private $stock;


    /**
     * Set stock
     *
     * @param integer $stock
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }
}
