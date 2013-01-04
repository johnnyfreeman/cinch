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
        $this->_blocks[] = $block;
    }

    public function display()
    {
        $output = '';

        foreach ($this->getBlocks() as $block)
        {
            $output .= $block->display();
        }

        return $output;
    }

    public function __toString()
    {
        return $this->display();
    }
}
