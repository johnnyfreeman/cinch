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

use Cinch\Events as CinchEvents;
use Cinch\Event\FilterAppEvent;
use Silex\Application as BaseApplication;
use Silex\Application\TwigTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\MonologTrait;
use Silex\Application\UrlGeneratorTrait;
use Symfony\Component\EventDispatcher\Event;

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

    /**
     * The trigger() method notifies all listeners of the given event.
     *
     * @param string  $eventName The name of the event to dispatch
     * @param object  $event     The Event instance to pass to each listener of that event
     * @return obect The Event instance
     */
    public function trigger($eventName, Event $event = null)
    {
        return $this['dispatcher']->dispatch($eventName, $event);
    }

    /**
     * Boots all service providers and packages.
     *
     * This method is automatically called by handle(), but you can use it
     * to boot all service providers when not handling a request.
     */
    public function boot()
    {
        parent::boot();

        $this->trigger(CinchEvents::APP_BOOTED, new FilterAppEvent($this));
    }
}
