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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Cinch\NamedRoutes;
use Symfony\Component\Yaml\Yaml;

/**
 * The site controller provider
 */
class SiteControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // get global content
        $app['content'] = Yaml::parse(file_get_contents(CINCH_ROOT.DS.'content'.DS.ltrim('_global.yml', DS)));
        
        // get routes
        $routes = Yaml::parse(file_get_contents(CINCH_APP.DS.'config'.DS.'routes.yml'));

        // register routes
        foreach ($routes as $uri => $file)
        {
            $route = $app->get($uri, function () use ($app, $file)
            {
                // get local content
                $page_content = Yaml::parse(file_get_contents(CINCH_ROOT.DS.'content'.DS.ltrim($file, DS)));

                // merge local data with global data
                $app['content'] = array_merge($app['content'], $page_content);

                // block access if this page isn't published
                if ($app['content']['published'] === false) {
                    throw new NotFoundHttpException;
                }

                return $app->renderView($app['content']['template'], $app['content']);
            });

            if ($uri === '/') {
                $route->bind(NamedRoutes::HOME);
            }
        }

        // register constant routes
        $app->mount('/admin', new AdminControllerProvider());
        $app->get('/login', 'admin.controller:login')->bind(NamedRoutes::LOGIN);
        $app->post('/admin/process_login', 'admin.controller:process_login')->bind(NamedRoutes::LOGIN_CHECK);

        return $app['controllers'];
    }
}