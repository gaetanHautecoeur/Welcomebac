<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Favori
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\FavoriRepository")
 */
class Favori
{
	/**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="favoris")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     */
    protected $utilisateur;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=2)
     */
    private $type;
    /**
     * @var string $date_modification
     *
     * @ORM\Column(name="date_modification", type="datetime")
     */
    private $date_modification;

    /**
     * @var string $id_element
     *
     * @ORM\Column(name="id_element", type="string", length=50)
     */
    private $id_element;

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
     * Set date_modification
     *
     * @param datetime $dateModification
     */
    public function setDateModification($dateModification)
    {
        $this->date_modification = $dateModification;
    }

    /**
     * Get date_modification
     *
     * @return datetime 
     */
    public function getDateModification()
    {
        return $this->date_modification;
    }

    /**
     * Set id_element
     *
     * @param string $idElement
     */
    public function setIdElement($idElement)
    {
        $this->id_element = $idElement;
    }

    /**
     * Get id_element
     *
     * @return string 
     */
    public function getIdElement()
    {
        return $this->id_element;
    }

    /**
     * Set utilisateur
     *
     * @param Welcomebac\EntitesBundle\Entity\Utilisateur $utilisateur
     */
    public function setUtilisateur(\Welcomebac\EntitesBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * Get utilisateur
     *
     * @return Welcomebac\EntitesBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
