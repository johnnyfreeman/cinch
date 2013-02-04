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

/*
 * The Cinch Block class.
 */
abstract class Package implements PackageInterface
{
    public function __construct(Application $app)
    {
        // run boot method on app start
        if (is_callable($boot = array($this, 'boot'))) {
            $app->on(CinchEvents::APP_BOOTED, $boot);
        }

        // run shutdown method on app stop
        if (is_callable($shutdown = array($this, 'shutdown'))) {
            $app->on(CinchEvents::APP_SHUTDOWN, $shutdown);
        }
    }
}