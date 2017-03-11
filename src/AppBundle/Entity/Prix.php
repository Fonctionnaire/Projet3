<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prix
 *
 * @ORM\Table(name="prix")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrixRepository")
 */
class Prix
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="normal", type="integer")
     */
    protected $normal;

    /**
     * @var int
     *
     * @ORM\Column(name="enfant", type="integer")
     */
    protected $enfant;

    /**
     * @var int
     *
     * @ORM\Column(name="gratuit", type="integer")
     */
    protected $gratuit;

    /**
     * @var int
     *
     * @ORM\Column(name="senior", type="integer")
     */
    protected $senior;

    /**
     * @var int
     *
     * @ORM\Column(name="reduit", type="integer")
     */
    protected $reduit;

    

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
     * Set normal
     *
     * @param integer $normal
     *
     * @return Prix
     */
    public function setNormal($normal)
    {
        $this->normal = $normal;

        return $this;
    }

    /**
     * Get normal
     *
     * @return integer
     */
    public function getNormal()
    {
        return $this->normal;
    }

    /**
     * Set enfant
     *
     * @param integer $enfant
     *
     * @return Prix
     */
    public function setEnfant($enfant)
    {
        $this->enfant = $enfant;

        return $this;
    }

    /**
     * Get enfant
     *
     * @return integer
     */
    public function getEnfant()
    {
        return $this->enfant;
    }

    /**
     * Set gratuit
     *
     * @param integer $gratuit
     *
     * @return Prix
     */
    public function setGratuit($gratuit)
    {
        $this->gratuit = $gratuit;

        return $this;
    }

    /**
     * Get gratuit
     *
     * @return integer
     */
    public function getGratuit()
    {
        return $this->gratuit;
    }

    /**
     * Set senior
     *
     * @param integer $senior
     *
     * @return Prix
     */
    public function setSenior($senior)
    {
        $this->senior = $senior;

        return $this;
    }

    /**
     * Get senior
     *
     * @return integer
     */
    public function getSenior()
    {
        return $this->senior;
    }

    /**
     * Set reduit
     *
     * @param integer $reduit
     *
     * @return Prix
     */
    public function setReduit($reduit)
    {
        $this->reduit = $reduit;

        return $this;
    }

    /**
     * Get reduit
     *
     * @return integer
     */
    public function getReduit()
    {
        return $this->reduit;
    }
}
