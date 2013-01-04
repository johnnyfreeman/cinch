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

use Silex\Application as BaseApplication;
use Silex\Application\TwigTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\MonologTrait;
use Silex\Application\UrlGeneratorTrait;

/*
 * The Cinch Application class.
 */
class Application extends BaseApplication
{
	/**
     * Version of Cinch
     */
    const VERSION = '1.0';

    /**
     * Twig Trait
     * 
     * render($view, $parameters, $response)
     * renderView($view, $parameters)
     */
    use TwigTrait;

    /**
     * Security Trait
     * 
     * user()
     * encodePassword(UserInterface $user, $password)
     */
    use SecurityTrait;

    /**
     * Monolog Trait
     * 
     * log($message, $context, $level)
     */
    use MonologTrait;

    /**
     * UrlGenerator Trait
     * 
     * path($route, $parameters)
     * url($route, $parameters)
     */
    use UrlGeneratorTrait;
}
