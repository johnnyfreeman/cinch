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


use Cinch\Blocks\Element;

/*
 * The Cinch Header Block class.
 */
class Paragragh extends Element
{
    /**
     * Constructor.
     */
    public function __construct($options)
    {
        $this->_html = $options['text'];
    }
}
