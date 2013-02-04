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

namespace Cinch\Event;

use Cinch\Application;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base class for events thrown in the HttpKernel component
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @api
 */
class FilterAppEvent extends Event
{
    /**
     * App
     * @var Application instance
     */
    private $app;

    /**
     * 
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getApp()
    {
        return $this->app;
    }
}
