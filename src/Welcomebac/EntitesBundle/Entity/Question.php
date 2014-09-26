<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Question
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Question
{
	/**
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="question", cascade={"persist"})
     */
    protected $reponses;
	/**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="questions")
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
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text $informations
     *
     * @ORM\Column(name="informations", type="text")
     */
    private $informations;


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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set informations
     *
     * @param text $informations
     */
    public function setInformations($informations)
    {
        $this->informations = $informations;
    }

    /**
     * Get informations
     *
     * @return text 
     */
    public function getInformations()
    {
        return $this->informations;
    }
    public function __construct()
    {
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add reponses
     *
     * @param Welcomebac\EntitesBundle\Entity\Reponse $reponses
     */
    public function addReponses(\Welcomebac\EntitesBundle\Entity\Reponse $reponses)
    {
    	$reponses->setQuestion($this);
        $this->reponses[] = $reponses;
    }

    /**
     * Get reponses
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReponses()
    {
        return $this->reponses;
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