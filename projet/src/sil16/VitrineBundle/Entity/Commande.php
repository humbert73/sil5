<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 */
class Commande
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $idClient;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var bool
     */
    private $etat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneDeCommande;

    /**
     * @var \sil16\VitrineBundle\Entity\Client
     */
    private $client;

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
     * Set idClient
     *
     * @param string $idClient
     * @return Commande
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return string 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param \bool $etat
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \bool 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Add ligneDeCommande
     *
     * @param \sil16\VitrineBundle\Entity\LigneDeCommande $ligneDeCommande
     * @return Commande
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
     * Set client
     *
     * @param \sil16\VitrineBundle\Entity\Client $client
     * @return Commande
     */
    public function setClient(\sil16\VitrineBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \sil16\VitrineBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ligneDeCommandes;


    /**
     * Get ligneDeCommandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLigneDeCommandes()
    {
        return $this->ligneDeCommandes;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lignesDeCommandes;


    /**
     * Add lignesDeCommandes
     *
     * @param \sil16\VitrineBundle\Entity\LigneDeCommande $lignesDeCommandes
     * @return Commande
     */
    public function addLignesDeCommande(\sil16\VitrineBundle\Entity\LigneDeCommande $lignesDeCommandes)
    {
        $this->lignesDeCommandes[] = $lignesDeCommandes;

        return $this;
    }

    /**
     * Remove lignesDeCommandes
     *
     * @param \sil16\VitrineBundle\Entity\LigneDeCommande $lignesDeCommandes
     */
    public function removeLignesDeCommande(\sil16\VitrineBundle\Entity\LigneDeCommande $lignesDeCommandes)
    {
        $this->lignesDeCommandes->removeElement($lignesDeCommandes);
    }

    /**
     * Get lignesDeCommandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLignesDeCommandes()
    {
        return $this->lignesDeCommandes;
    }

    public function getPrice() {
        $prix = 0;

        foreach ($this->getLignesDeCommandes() as $ligneDeCommande) {
            $prix += $ligneDeCommande->getArticle()->getPrice()*$ligneDeCommande->getQuantite();
        }

        return $prix;
    }
}
