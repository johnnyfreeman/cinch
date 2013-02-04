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

namespace Cinch\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class AdminController
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function dashboard()
    {
        return 'Welcome to your dashboard!';
    }

    public function list_packages()
    {
        return 'listing all packages...';
    }

    public function lookup_package()
    {
        // find package or $app->abort()
        return 'looking for you\'re package...';
    }

    public function login(Request $request) {
        return $this->app->renderView('login.html', array(
            'error'         => $this->app['security.last_error']($request),
            'last_username' => $this->app['session']->get('_security.last_username'),
        ));
    }

    public function process_login() {
        if ($this->app['security']->isGranted('ROLE_ADMIN')) {
            return $this->app->redirect($this->app->path(NamedRoutes::ADMIN));
        }
    }
}