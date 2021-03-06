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

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cinch\NamedRoutes;

/**
 * The admin controller provider
 */
class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // create a new controller based on the default route
        $admin = $app['controllers_factory'];

        // lock it down
        $admin->secure('ROLE_ADMIN'); // makes admin routes throw an AccessDeniedException

        // dashboard
        $admin->get('/dashboard', 'admin.controller:dashboard')->bind(NamedRoutes::ADMIN);
        // make default route redirect to the dashboard
        $admin->get('/', function() use ($app) {
            return $app->redirect($app->url(NamedRoutes::ADMIN), 301);
        });

        // list packages
        $admin->get('/packages', 'admin.controller:list_packages');

        // get ALL packages, mount each admin controller provider
        // foreach ($this->app['packages'] as $package) {
        //     $uri = '/packages/' . strtolower($package->namespace);
        //     $provider_class = new $package->namespace.'\\Provider\\AdminControllerProvider'();
        //     $admin->mount($uri, $provider);
        //     $admin->get($uri, array($provider, 'index_action'))
        // }

        $admin->get('/packages/{package}', function ($package) use ($app) {
            return $app->abort(404, '<strong>'.$package.'</strong> package not found.');
        })->assert('package', '.*');

        // catch all
        $admin->get('/{page}', function () use ($app) {
            return $app->abort(404, "Admin page does not exist");
        })->assert('page', '.*');

        return $admin;
    }
}