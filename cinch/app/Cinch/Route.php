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

use Silex\Route as BaseRoute;
use Silex\Route\SecurityTrait;

/*
 * The Cinch Route class.
 */
class Route extends BaseRoute
{
	/**
	 * Security Trait
	 * 
	 * secure($roles)
	 */
    use SecurityTrait;
}
