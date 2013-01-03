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

namespace HelloWorld\Blocks;

use Cinch\BlockInterface;

/*
 * The HelloWorld Block class.
 */
class SayGoodbye implements BlockInterface
{
    protected $_name;

    /**
     * Constructor.
     */
    public function __construct($options)
    {
        $this->_name = $options['name'];
    }

    public function hydrate()
    {
        return;
    }

    public function render()
    {
        return 'Later, ' . $this->_name . '!';
    }
}
