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
use Twig_Environment;

class AdminController
{
    protected $twig;
    
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
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

    public function login() {
        return 'login page';
        // return $app->render('login.html', array(
        //     'error'         => $app['security.last_error']($request),
        //     'last_username' => $app['session']->get('_security.last_username'),
        // ));
    }

    public function process_login(Request $request) {
        return 'login page';
    }

    public function process_logout(Request $request) {
        return 'logging out... redirecting...';
    }
}