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

namespace Cinch\Provider;

use Monolog\Logger;
use Monolog\Handler\ChromePHPHandler;
use Silex\Application;
use Silex\Provider\MonologServiceProvider as SilexMonologServiceProvider;

/**
 * Monolog integration for Cinch
 */
class MonologServiceProvider extends SilexMonologServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);

        $app['monolog.logfile'] = CINCH_APP . '/logs/errors.log';
        $app['monolog.level'] = Logger::DEBUG;
        $app['monolog.name'] = 'cinch';

        // register the ChromePHPHandler
        $app['monolog']->pushHandler(new ChromePHPHandler());
    }
}
