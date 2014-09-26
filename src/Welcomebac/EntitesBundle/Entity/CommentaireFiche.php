<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\CommentaireFiche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\CommentaireFicheRepository")
 */
class CommentaireFiche
{
	/**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="commentaires")
     * @ORM\JoinColumn(name="id_fiche", referencedColumnName="id")
     */
    protected $fiche;
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
     * Set fiche
     *
     * @param Welcomebac\EntitesBundle\Entity\Fiche $fiche
     */
    public function setFiche(\Welcomebac\EntitesBundle\Entity\Fiche $fiche)
    {
        $this->fiche = $fiche;
    }

    /**
     * Get fiche
     *
     * @return Welcomebac\EntitesBundle\Entity\Fiche 
     */
    public function getFiche()
    {
        return $this->fiche;
    }
}