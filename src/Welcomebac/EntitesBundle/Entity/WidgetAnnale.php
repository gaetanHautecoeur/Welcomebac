<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\WidgetAnnale
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class WidgetAnnale
{
	/**
     * @ORM\ManyToOne(targetEntity="WidgetAnnale", inversedBy="enfants", cascade={"all"})
     * @ORM\JoinColumn(name="id_parent", referencedColumnName="id")
     */
    protected $parent;
    
	/**
     * @ORM\OneToMany(targetEntity="WidgetAnnale", mappedBy="parent", cascade={"all"})
     * @ORM\OrderBy({"ordre" = "ASC"})
     */
    protected $enfants;
    
	/**
     * @ORM\ManyToOne(targetEntity="Annale", inversedBy="widgets")
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
     * @ORM\OneToMany(targetEntity="VariableWidgetAnnale", mappedBy="widget", cascade={"all"})
     */
    protected $variables;

    /**
     * @var text $twig
     *
     * @ORM\Column(name="twig", type="string", length=100)
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
     * Set parent
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetAnnale $parent
     */
    public function setParent(\Welcomebac\EntitesBundle\Entity\WidgetAnnale $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Welcomebac\EntitesBundle\Entity\WidgetAnnale 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfants
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetAnnale $enfants
     */
    public function addEnfants(\Welcomebac\EntitesBundle\Entity\WidgetAnnale $enfants)
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
    
    public function __construct()
    {
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add variables
     *
     * @param Welcomebac\EntitesBundle\Entity\VariableWidget $variables
     */
    public function addVariables(\Welcomebac\EntitesBundle\Entity\VariableWidgetAnnale $variables)
    {
        $this->variables[] = $variables;
    }
    
    /**
     * Get variables
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVariables()
    {
        return $this->variables;
    }
    
    public function getVariable($string){
        $iterator = $this->getVariables()->getIterator();
        while($iterator->valid()){
        	$variable = $iterator->current();
        	if($variable->getNom() == $string){
        		return $variable->getValeur();
        	}
        	$iterator->next();
        }
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
}