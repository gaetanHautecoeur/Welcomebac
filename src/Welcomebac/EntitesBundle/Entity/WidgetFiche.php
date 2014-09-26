<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\WidgetFiche
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class WidgetFiche
{
	/**
     * @ORM\ManyToOne(targetEntity="WidgetFiche", inversedBy="enfants", cascade={"all"})
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id")
     */
    protected $parent;
    
	/**
     * @ORM\OneToMany(targetEntity="WidgetFiche", mappedBy="parent")
     * @ORM\OrderBy({"ordre" = "ASC"})
     */
    protected $enfants;
    
	/**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="widgets")
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
     * @var text $variables
     *
     * @ORM\Column(name="variables", type="text")
     */
    private $variables;
    
    /**
     * @var text $twig
     *
     * @ORM\Column(name="twig", type="string", length=30)
     */
    private $twig;

    /**
     * @var integer $ordre
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;
    
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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set valeur
     *
     * @param text $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return text 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
    public function __construct()
    {
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set parent
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetFiche $parent
     */
    public function setParent(\Welcomebac\EntitesBundle\Entity\WidgetFiche $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Welcomebac\EntitesBundle\Entity\WidgetFiche 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfants
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetFiche $enfants
     */
    public function addEnfants(\Welcomebac\EntitesBundle\Entity\WidgetFiche $enfants)
    {
        $this->enfants[] = $enfants;
    }

    /**
     * Get enfants
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEnfants()
    {
        return $this->enfants;
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

    /**
     * Set variables
     *
     * @param text $variables
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    /**
     * Get variables
     *
     * @return text 
     */
    public function getVariables()
    {
        return $this->variables;
    }


    /**
     * Get twig
     *
     * @return string(30) 
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Set twig
     *
     * @param string $twig
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }
}