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
// use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
            $app->get($uri, function () use ($app, $file)
            {
                // get local content
                $page_content = Yaml::parse(file_get_contents(CINCH_ROOT.DS.'content'.DS.ltrim($file, DS)));

                // merge local data with global data
                $app['content'] = array_merge($app['content'], $page_content);

                // block access if this page isn't published
                if ($app['content']['published'] === false) {
                    // TODO: allow admins to view draft pages
                    // throw new AccessDeniedException;
                }

                return $app->renderView($app['content']['template'], $app['content']);
            });
        // ->bind(NamedRoutes::HOME);
        }

        // register constant routes
        $app->mount('/admin', new AdminControllerProvider());
        $app->get('/login', 'admin.controller:login')->bind(NamedRoutes::LOGIN);
        $app->post('/login', 'admin.controller:process_login');
        $app->match('/logout', 'admin.controller:process_logout')->bind(NamedRoutes::LOGOUT);

        return $app['controllers'];
    }
}