<?php

namespace Welcomebac\EntitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Welcomebac\EntitesBundle\Entity\TagAnnale
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TagAnnale
{
	/**
     * @ORM\ManyToOne(targetEntity="Annale", inversedBy="tags")
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
     * @var integer $id_annale
     *
     * @ORM\Column(name="id_annale", type="integer", length=11)
     */
    private $id_annale;

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
     * Set id_annale
     *
     * @param integer $idAnnale
     */
    public function setIdAnnale($idAnnale)
    {
        $this->id_annale = $idAnnale;
    }

    /**
     * Get id_annale
     *
     * @return integer 
     */
    public function getIdAnnale()
    {
        return $this->id_annale;
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