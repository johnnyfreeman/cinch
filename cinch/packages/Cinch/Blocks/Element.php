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

namespace Cinch\Blocks;

use Cinch\Block;

/*
 * The Cinch Element Block class.
 */
class Element extends Block
{
    /**
     * Name of the tag. Ex "input"
     *
     * @var string
     **/
    protected $_tagName;
    
    /**
     * Array of element attributes
     *
     * @var array
     **/
    protected $_attributes = array();
    
    /**
     * Self closing flag
     *
     * @var string
     **/
    protected $_selfClosingTag = FALSE;
    
    /**
     * Inner Html
     *
     * @var string
     **/
    protected $_html = '';

    public function display()
    {
        // opening angle bracket
        $html = '<';

        // tag
        $html .= $this->_tagName;

        $attributes = array();
        foreach ($this->_attributes as $name => $value)
        {
            if (is_string($value))
            {
                $attributes[] = $name . '="' . $value . '"';
            }
        }
        $attributes = implode(' ', $attributes);

        if (!empty($attributes)) {
            $html .= ' '.$attributes;
        }

        // close angle bracket
        $html .= '>';

        // stop right here if this is a self closing tag
        if ($this->_selfClosingTag) {
            return $html;
        }

        // html
        $html .= $this->_html;

        // close tag
        $html .= '</'.$this->_tagName.'>';

        return $html;
    }

    public function edit()
    {
        return '';
    }

    public function update()
    {
        return;
    }
}
