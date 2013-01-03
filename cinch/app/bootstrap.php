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

use Cinch\Application;
use Cinch\NamedRoutes;
use Cinch\Provider\AdminControllerProvider;
use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Parser as YamlParser;
use Monolog\Logger;


/*
 * The Cinch bootstrap file.
 */

// get some start statistics
defined('CINCH_START_TIME') or define('CINCH_START_TIME', microtime(true));
defined('CINCH_START_MEM') or define('CINCH_START_MEM', memory_get_usage());


// register autoloader
$autoloader = require_once CINCH_ROOT.'vendor/autoload.php';
// $autoloader->add('Cinch', CINCH_APP);
// $autoloader->add('Packages', CINCH_PACKAGES);
// echo "<pre>"; print_r($autoloader); echo "</pre>"; die();

// get configuration
$yaml = new YamlParser();
$config = $yaml->parse(file_get_contents(CINCH_APP . 'config/routes.yml'));


// application setup
$app = new Application();


// register routes
foreach ($config['routes'] as $uri => $route) {
    $app->get($uri, function () use ($app, $route) {
        return $app->renderView($route['template'], $route['regions']);
    });
// ->bind(NamedRoutes::HOME);
}


// register admin controllers
$admin = new AdminControllerProvider();
$app->mount('/admin', $admin);

// register auth controllers
$app->get('/login', array($admin, 'login'))->bind(NamedRoutes::LOGIN);
$app->post('/login', array($admin, 'process_login'));
$app->match('/logout', array($admin, 'process_logout'))->bind(NamedRoutes::LOGOUT);


// log all errors
$app->error(function(Exception $e) use ($app) {
    $app->log((string) $e);
});


// 404 handler
$app->error(function(NotFoundHttpException $e) use ($app) {
    // render template if 404.html.twig is_readable
    // overwise do nothing
    if (is_readable(THEMES_PATH.'/CURRENT_THEME/errors/404.html.twig'))
    {
        return $app->render('errors/404.html.twig', array(
            'name' => $name,
        ));
    }
});


// // handler for AccessDeniedExceptions
// $app->error(function (AccessDeniedException $e)
// {
// 	return $app->redirect( $app->url(Cinch\Route\NamedRoutes::LOGIN));
// });

// process Request, return Response
$app->run();