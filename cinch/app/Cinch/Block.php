<?php

/**
 * Cinch
 *
 * Cinch is a sick CMS for developers. 
 *
 * @package    cinch
 * @version    1.0
 * @author     Johnny Freeman
 * @license    http://www.buildwithcinch.com/license
 * @copyright  (c) 2011 - 2012 Johnny Freeman All right reserved.
 * @link       http://www.buildwithcinch.com
 */

namespace Cinch;

use Cinch\BlockInterface;
use Twig_Environment;

/*
 * The Cinch Block class.
 */
abstract class Block implements BlockInterface
{
    /**
     * template path
     * 
     * @var String
     */
    protected $_template;
    
    /**
     * Parent Region
     * 
     * @var String
     */
    protected $_parentRegion;
    
    /**
     * Block options
     * 
     * @var Mixed
     */
    protected $_options = array();
    
    /**
     * Cinch Application
     * 
     * @var Twig_Environment
     */
    protected $_app;

    /**
     * Constructor.
     */
    public function __construct($options = array())
    {
        $this->_options = $options;
    }

    public function render($template, $options)
    {
        return $this->_app['twig']->render($template, $options);
    }

    public function display()
    {
        return $this->render($this->_template, $this->_options);
    }

    public function setParentRegion(Region $region)
    {
        $this->_parentRegion = $region;
    }

    public function setApp(Application $app)
    {
        $this->_app = $app;
    }

    public function __toString()
    {
        return $this->display();
    }
}