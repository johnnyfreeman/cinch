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
 * The Cinch Column Block class.
 */
class Column extends Block
{
    public function display()
    {
        return $this->render('@Cinch/templates/column.html');
    }

    public function edit()
    {
        return $this->render('@Cinch/edit-column.html', $this->_options);
    }

    public function update()
    {
        // process
    }
}
