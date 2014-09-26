<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Fiche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Welcomebac\EntitesBundle\Repository\FicheRepository")
 */
class Fiche
{
    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="fiche")
     */
    protected $questions;
	/**
     * @ORM\ManyToMany(targetEntity="Annale", inversedBy="fichesRecommandees")
     * @ORM\JoinTable(name="RecommandationFicheAnnale")
     */
    protected $annalesRecommandees;
	/**
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="fiches")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id")
     */
    protected $matiere;
    /**
     * @ORM\OneToMany(targetEntity="TagFiche", mappedBy="fiche")
     */
    protected $tags;
    /**
     * @ORM\OneToMany(targetEntity="WidgetFiche", mappedBy="fiche")
     */
    protected $widgets;
    /**
     * @ORM\OneToMany(targetEntity="CommentaireFiche", mappedBy="fiche")
     */
    protected $commentaires;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $id_matiere
     *
     * @ORM\Column(name="titre", type="string", length=150)
     */
    private $titre;
    
    /**
     * @var string $id_wb
     *
     * @ORM\Column(name="id_wb", type="string", length=150, nullable=true)
     */
    private $id_wb;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;	  
    
	/**
     * @var integer $nombreVisites
     *
     * @ORM\Column(name="nombreVisites", type="integer")
     */
    private $nombreVisites;
    
	/**
     * @var integer $quizVisites
     *
     * @ORM\Column(name="quizVisites", type="integer")
     */
    private $quizVisites;
	/**
     * @var integer $facebookTitle
     *
     * @ORM\Column(name="facebookTitle", type="text")
     */
    private $facebookTitle;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=170, nullable=true)
     */
    private $url;
	
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
     * Set titre
     *
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
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
     * Set matiere
     *
     * @param Welcomebac\EntitesBundle\Entity\Matiere $matiere
     */
    public function setMatiere(\Welcomebac\EntitesBundle\Entity\Matiere $matiere)
    {
        $this->matiere = $matiere;
    }

    /**
     * Get matiere
     *
     * @return Welcomebac\EntitesBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tags
     *
     * @param Welcomebac\EntitesBundle\Entity\TagFiche $tags
     */
    public function addTags(\Welcomebac\EntitesBundle\Entity\TagFiche $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add commentaires
     *
     * @param Welcomebac\EntitesBundle\Entity\CommentaireFiche $commentaires
     */
    public function addCommentaires(\Welcomebac\EntitesBundle\Entity\CommentaireFiche $commentaires)
    {
        $this->commentaires[] = $commentaires;
    }

    /**
     * Get commentaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add widgets
     *
     * @param Welcomebac\EntitesBundle\Entity\WidgetFiche $widgets
     */
    public function addWidgets(\Welcomebac\EntitesBundle\Entity\WidgetFiche $widgets)
    {
        $this->widgets[] = $widgets;
    }

    /**
     * Get widgets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * Add annalesRecommandees
     *
     * @param Welcomebac\EntitesBundle\Entity\Annale $annalesRecommandees
     */
    public function addAnnalesRecommandees(\Welcomebac\EntitesBundle\Entity\Annale $annalesRecommandees)
    {
        $this->annalesRecommandees[] = $annalesRecommandees;
    }

    /**
     * Get annalesRecommandees
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAnnalesRecommandees()
    {
        return $this->annalesRecommandees;
    }

    /**
     * Add questions
     *
     * @param Welcomebac\EntitesBundle\Entity\Question $questions
     */
    public function addQuestions(\Welcomebac\EntitesBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
    }

    /**
     * Get questions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set quizVisites
     *
     * @param integer $quizVisites
     */
    public function setQuizVisites($quizVisites)
    {
        $this->quizVisites = $quizVisites;
    }

    /**
     * Get quizVisites
     *
     * @return integer 
     */
    public function getQuizVisites()
    {
        return $this->quizVisites;
    }

    /**
     * Set nombreVisites
     *
     * @param integer $nombreVisites
     */
    public function setNombreVisites($nombreVisites)
    {
        $this->nombreVisites = $nombreVisites;
    }

    /**
     * Get nombreVisites
     *
     * @return integer 
     */
    public function getNombreVisites()
    {
        return $this->nombreVisites;
    }

    /**
     * Set id_wb
     *
     * @param string $idWb
     */
    public function setIdWb($idWb)
    {
        $this->id_wb = $idWb;
    }

    /**
     * Get id_wb
     *
     * @return string 
     */
    public function getIdWb()
    {
        return $this->id_wb;
    }

    /**
     * Set facebookTitle
     *
     * @param text $facebookTitle
     */
    public function setFacebookTitle($facebookTitle)
    {
        $this->facebookTitle = $facebookTitle;
    }

    /**
     * Get facebookTitle
     *
     * @return text 
     */
    public function getFacebookTitle()
    {
        return $this->facebookTitle;
    }
    /**
     * Set url
     *
     * @param text $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return text 
     */
    public function getUrl()
    {
        return $this->url;
    }
}