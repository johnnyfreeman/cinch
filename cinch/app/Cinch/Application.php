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
use Monolog\Logger;
use Monolog\Handler\ChromePHPHandler;
use Cinch\TwigExtension as CinchTwigExtension;
use Symfony\Component\HttpFoundation\Request;

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

        $this['debug'] = CINCH_ENV !== 'PROD';
        $this['route_class'] = 'Cinch\\Route';

        // get cinch config

        // Register Monolog
        $this->register(new MonologServiceProvider(), array(
            'monolog.logfile' => CINCH_APP . '/logs/errors.log',
            'monolog.level' => Logger::DEBUG,
            'monolog.name' => 'cinch'
        ));
        $this['monolog']->pushHandler(new ChromePHPHandler());

        // Register Url Generator
        $this->register(new UrlGeneratorServiceProvider());

        // base url
        $request = Request::createFromGlobals();

        // update request context with globals
        $this['request_context']->fromRequest($request);
        $this['base_url'] = $request->getBasePath();

        // current theme
        $theme_uri = '/themes/site/smartstart';
        $this['theme_url'] = $this['base_url'] . $theme_uri;
        $theme_path = PUBLIC_PATH . $theme_uri;

        // Register Twig
        $this->register(new TwigServiceProvider(), array(
            'twig.path' => $theme_path, // view folder of current theme
        ));

        $this['twig']->addExtension(new CinchTwigExtension());
    }
}
