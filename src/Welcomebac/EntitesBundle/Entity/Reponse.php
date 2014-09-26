<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\Reponse
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Reponse
{
	/**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="reponses", cascade={"all"})
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     */
    protected $question;
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
     * @var boolean $correcte
     *
     * @ORM\Column(name="correcte", type="boolean")
     */
    private $correcte;


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
     * Set correcte
     *
     * @param boolean $correcte
     */
    public function setCorrecte($correcte)
    {
        $this->correcte = $correcte;
    }

    /**
     * Get correcte
     *
     * @return boolean 
     */
    public function getCorrecte()
    {
        return $this->correcte;
    }

    /**
     * Set question
     *
     * @param Welcomebac\EntitesBundle\Entity\Question $question
     */
    public function setQuestion(\Welcomebac\EntitesBundle\Entity\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return Welcomebac\EntitesBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}