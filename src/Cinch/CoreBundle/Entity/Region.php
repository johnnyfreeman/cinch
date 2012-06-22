<?php

namespace Cinch\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cinch\CoreBundle\Entity\Region
 */
class Region
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $alias
     */
    private $alias;

    /**
     * @var string $template
     */
    private $template;

    /**
     * @var ArrayCollection $blocks
     */
    protected $blocks;

    /**
     * @var Page $page
     */
    protected $page;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
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
     * Set alias
     *
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set template
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }
}