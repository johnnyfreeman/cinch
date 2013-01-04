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

namespace Cinch;

use Silex\Application as BaseApplication;
use Silex\Application\TwigTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\MonologTrait;
use Silex\Application\UrlGeneratorTrait;
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
use Exception;

/*
 * The Cinch Application class.
 */
class Application extends BaseApplication
{
	/**
     * Version of Cinch
     */
    const VERSION = '1.0';

    /**
     * Twig Trait
     * 
     * render($view, $parameters, $response)
     * renderView($view, $parameters)
     */
    use TwigTrait;

    /**
     * Security Trait
     * 
     * user()
     * encodePassword(UserInterface $user, $password)
     */
    use SecurityTrait;

    /**
     * Monolog Trait
     * 
     * log($message, $context, $level)
     */
    use MonologTrait;

    /**
     * UrlGenerator Trait
     * 
     * path($route, $parameters)
     * url($route, $parameters)
     */
    use UrlGeneratorTrait;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $app = $this;

        $app['debug'] = CINCH_ENV !== 'PROD';
        $app['route_class'] = 'Cinch\\Route';

        // Register Monolog
        $app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => CINCH_APP . '/logs/errors.log',
            'monolog.level' => Logger::DEBUG,
            'monolog.name' => 'cinch'
        ));
        $app['monolog']->pushHandler(new ChromePHPHandler());

        // Register Url Generator
        $app->register(new UrlGeneratorServiceProvider());

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

        // base url
        $request = Request::createFromGlobals();

        // update request context with globals
        $app['request_context']->fromRequest($request);
        $app['base_url'] = $request->getBasePath();

        // current theme
        $theme_uri = DIRECTORY_SEPARATOR . 'themes' 
                   . DIRECTORY_SEPARATOR . 'site'
                   . DIRECTORY_SEPARATOR . $app['content']['theme'];
        $app['theme_url'] = $app['base_url'] . $theme_uri;
        // echo '<pre>'; print_r($app['theme_url']); echo '</pre>'; die();
        $theme_path = PUBLIC_PATH . $theme_uri;


        // 404 handler
        $app->error(function(NotFoundHttpException $e) use ($app, $theme_path) {
            // render template if 404.html is readable
            // overwise rethrow exception
            if (is_readable($theme_path . '/404.html'))
            {
                return $app->render('/404.html', $app['content']);
            }
            else
            {
                throw $e;
            }
        });


        // Register Twig
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => $theme_path, // view folder of current theme
        ));

        $app['twig']->addExtension(new CinchTwigExtension());
    }
}
