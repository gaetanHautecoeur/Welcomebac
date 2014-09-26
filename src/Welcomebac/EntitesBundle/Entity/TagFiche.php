<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\TagFiche
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TagFiche
{
	/**
     * @ORM\ManyToOne(targetEntity="Fiche", inversedBy="tags")
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
     * @var string $tag
     *
     * @ORM\Column(name="tag", type="string", length=50)
     */
    private $tag;


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
     * Set tag
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
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