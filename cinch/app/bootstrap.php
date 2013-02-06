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
use Cinch\Controller\AdminController;
use Cinch\Event\FilterAppEvent;
use Cinch\Events as CinchEvents;
use Cinch\Provider\PackageServiceProvider;
use Cinch\Provider\SiteControllerProvider;
use Cinch\Provider\MonologServiceProvider;
use Cinch\Provider\SecurityServiceProvider;
use Cinch\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
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

// start application
$app = new Application();

$app['debug'] = CINCH_ENV === 'DEV';
$app['route_class'] = 'Cinch\\Route';

// update request context with globals and set base url
$request = Request::createFromGlobals();
$app['request_context']->fromRequest($request);
$app['base_url'] = $request->getBasePath();


// register admin controller as a service
$app['admin.controller'] = $app->share(function() use ($app) {
    return new AdminController($app);
});


// register controller providers
$site = new SiteControllerProvider();
$site->connect($app);

// current theme
$theme_uri = DS.'themes'.DS.'site'.DS.$app['content']['theme'];
$app['theme.url'] = $app['base_url'] . $theme_uri;
$app['theme.path'] = PUBLIC_PATH . $theme_uri;


// Register Third Party Services
$app->register(new PackageServiceProvider($autoloader));
$app->register(new MonologServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new SecurityServiceProvider());
$app->register(new SessionServiceProvider());


/**
 * ERROR HANDLING
 */

// 404 handler
// render template if 404.html is readable
// overwise rethrow exception
$app->error(function(NotFoundHttpException $e) use ($app)
{
    if (is_readable($app['theme.path'] . '/404.html')) {
        return $app->render('/404.html', $app['content']);
    } 

    // fallback to generic 404
    return $app->render('/errors/404.html', $app['content']);
});


// log all errors
$app->error(function(Exception $e) use ($app) {
    $app->log((string) $e);
});



$app->after(function($response) use ($app) {
    $app->trigger(CinchEvents::CONTENT_PARSED, new FilterAppEvent($app));
});

$app->finish(function($response) use ($app) {
    $app->trigger(CinchEvents::APP_STOP, new FilterAppEvent($app));
});

// process Request, return Response
$app->run($request);