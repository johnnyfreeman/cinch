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
use Cinch\Provider\SiteControllerProvider;
use Cinch\Provider\MonologServiceProvider;
use Cinch\Provider\TwigServiceProvider;
use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;

/*
 * The Cinch bootstrap file.
 */

// get some start statistics
defined('CINCH_START_TIME') or define('CINCH_START_TIME', microtime(true));
defined('CINCH_START_MEM') or define('CINCH_START_MEM', memory_get_usage());

// register autoloader
$autoloader = require_once CINCH_ROOT.DS.'vendor'.DS.'autoload.php';

// register errors as exceptions
ErrorHandler::register();

// register packages with the autoloader
// $autoloader->add('Package_Namespace', CINCH_PACKAGES);

// start application
$app = new Application();

$app['debug'] = CINCH_ENV !== 'PROD';
$app['route_class'] = 'Cinch\\Route';

// update request context with globals and set base url
$request = Request::createFromGlobals();
$app['request_context']->fromRequest($request);
$app['base_url'] = $request->getBasePath();

// register controllers
$site = new SiteControllerProvider();
$site->connect($app);

// log all errors
$app->error(function(Exception $e) use ($app) {
    $app->log((string) $e);
});

// current theme
$theme_uri = DS.'themes'.DS.'site'.DS.$app['content']['theme'];
$app['theme_url'] = $app['base_url'] . $theme_uri;
$app['theme_path'] = PUBLIC_PATH . $theme_uri;


// 404 handler
// render template if 404.html is readable
// overwise rethrow exception
$app->error(function(NotFoundHttpException $e) use ($app) {
    if (is_readable($app['theme_path'] . '/404.html')) {
        return $app->render('/404.html', $app['content']);
    } else {
        throw $e;
    }
});

// Register Third Party Services
$app->register(new MonologServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TwigServiceProvider());

// // handler for AccessDeniedExceptions
// $app->error(function (AccessDeniedException $e)
// {
// 	return $app->redirect( $app->url(Cinch\Route\NamedRoutes::LOGIN));
// });

// process Request, return Response
$app->run($request);