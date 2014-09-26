<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\CommentaireCorrige
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\CommentaireCorrigeRepository")
 */
class CommentaireCorrige
{
	/**
     * @ORM\ManyToOne(targetEntity="Annale", inversedBy="commentairesCorrige")
     * @ORM\JoinColumn(name="id_annale", referencedColumnName="id")
     */
    protected $annale;
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $auteur
     *
     * @ORM\Column(name="auteur", type="string", length=100)
     */
    private $auteur;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var text $commentaire
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
     * @var boolean $visible
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;


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
     * Set auteur
     *
     * @param string $auteur
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commentaire
     *
     * @param text $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Get commentaire
     *
     * @return text 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set annale
     *
     * @param Welcomebac\EntitesBundle\Entity\Annale $annale
     */
    public function setAnnale(\Welcomebac\EntitesBundle\Entity\Annale $annale)
    {
        $this->annale = $annale;
    }

    /**
     * Get annale
     *
     * @return Welcomebac\EntitesBundle\Entity\Annale 
     */
    public function getAnnale()
    {
        return $this->annale;
    }
}