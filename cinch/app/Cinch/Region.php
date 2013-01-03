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
 * The Cinch Region class.
 */
class Region
{
    protected $_blocks = array();
    protected $_twig;

    public function __construct($name = '')
    {
        $this->_name = $name;
    }

    public function getBlocks()
    {
        return $this->_blocks;
    }

    public function addBlock($block)
    {
        // instantiate blocks and store them
        $class = $block['class'];
        $config = $block['options'];
        $newBlock = new $class($config);

        if (false === $newBlock instanceof BlockInterface) {
            throw new \Exception('The ' . $class . ' class must implement BlockInterface');
        }

        $this->_blocks[] = $newBlock;
    }

    public function getDispatcher(EventDispatcher $dispatcher)
    {
        $this->_eventDispatcher = $dispatcher;
    }

    public function setTwig(Twig_Environment $twig)
    {
        $this->_twig = $twig;
    } 

    public function hydrate()
    {
        foreach ($this->getBlocks() as $block)
        {
            $block->hydrate();
        }
    }

    public function render()
    {
        $output = '';

        foreach ($this->getBlocks() as $block)
        {
            $output .= $block->render();
        }

        return $output;
    }

    public function __toString()
    {
        return $this->render();
    }
}
