<?php

namespace Cinch\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cinch\CoreBundle\Entity\Page
 */
class Page
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var ArrayCollection $regions
     */
    protected $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add region
     *
     * @param Region $region
     */
    public function addRegion(Region $region)
    {
        $this->regions[] = $region;
    }
}