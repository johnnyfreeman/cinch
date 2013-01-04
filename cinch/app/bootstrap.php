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
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Monolog\Handler\ChromePHPHandler;
use Cinch\TwigExtension as CinchTwigExtension;
use Cinch\NamedRoutes;
use Cinch\Provider\AdminControllerProvider;
use Composer\Autoload\ClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;
use Monolog\Logger;

/*
 * The Cinch bootstrap file.
 */

// get some start statistics
defined('CINCH_START_TIME') or define('CINCH_START_TIME', microtime(true));
defined('CINCH_START_MEM') or define('CINCH_START_MEM', memory_get_usage());

// register autoloader
$autoloader = require_once CINCH_ROOT.DS.'vendor'.DS.'autoload.php';
// $autoloader->add('Cinch', CINCH_APP);
// $autoloader->add('Packages', CINCH_PACKAGES);
// echo "<pre>"; print_r($autoloader); echo "</pre>"; die();

// start application
$app = new Application();

$app['debug'] = CINCH_ENV !== 'PROD';
$app['route_class'] = 'Cinch\\Route';

// create new request
$request = Request::createFromGlobals();

// update request context with globals
$app['request_context']->fromRequest($request);

// set base url
$app['base_url'] = $request->getBasePath();

// get routes
$routes = Yaml::parse(file_get_contents(CINCH_APP.DS.'config'.DS.'routes.yml'));

// get global content
$app['content'] = Yaml::parse(file_get_contents(CINCH_ROOT.DS.'content'.DS.ltrim('_global.yml', DS)));

// register routes
foreach ($routes as $uri => $file)
{
    $app->get($uri, function () use ($app, $file)
    {
        // merge local data with global data
        $local = Yaml::parse(file_get_contents(CINCH_ROOT.DS.'content'.DS.ltrim($file, DS)));
        $content = $app['content'] = array_merge($app['content'], $local);

        if ($content['published'] === false) {
            // AND not admin
            throw new NotFoundHttpException;
        }

        return $app->renderView($content['template'], $content);
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

// Register Monolog
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => CINCH_APP . '/logs/errors.log',
    'monolog.level' => Logger::DEBUG,
    'monolog.name' => 'cinch'
));
$app['monolog']->pushHandler(new ChromePHPHandler());

// Register Url Generator
$app->register(new UrlGeneratorServiceProvider());

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


// Register Twig
$app->register(new TwigServiceProvider(), array(
    // 'twig.path' => $app['theme_path'], // view folder of current theme
));

$app['twig.loader.filesystem']->addPath($app['theme_path']);
$app['twig']->addExtension(new CinchTwigExtension());


/**
 * THIS NEEDS TO BE REFACTORED!
 */
// quick and dirty add template dir for Cinch Package
$paths = array();
if (is_dir($app['theme_path'].DS.'packages'.DS.'cinch')) {
    $paths[] = $app['theme_path'].DS.'packages'.DS.'cinch';
}
$paths[] = CINCH_PACKAGES.DS.'Cinch';
$app['twig.loader.filesystem']->setPaths($paths, 'cinch');

// template paths for each package
// foreach ($active_packages as $package) {
//     $app['twig.loader.filesystem']->addPath(array(
//             // add a place for theme developers to override package templates
//             $app['theme_path'].DS.'packages'.DS.$package['name'], 
//             $package['template_dir']
//         ), 
//         // namespace for this package's templates
//         $package['name']
//     );
// }


// // handler for AccessDeniedExceptions
// $app->error(function (AccessDeniedException $e)
// {
// 	return $app->redirect( $app->url(Cinch\Route\NamedRoutes::LOGIN));
// });

// process Request, return Response
$app->run($request);