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

use Cinch\TwigExtension;
use Silex\Application;
use Silex\Provider\TwigServiceProvider as SilexTwigServiceProvider;

/**
 * Twig integration for Cinch
 */
class TwigServiceProvider extends SilexTwigServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);

        // register the Cinch twig extension
        $app['twig']->addExtension(new TwigExtension());
    }

    public function boot(Application $app)
    {
        parent::boot($app);

        // register the main theme directory under the main namespace
        $app['twig.loader.filesystem']->addPath($app['theme.path']);

        // template paths for each package
        foreach ($app['packages'] as $package) {
            $paths = array();
            if (is_dir($app['theme.path'].DS.'packages'.DS.$package)) {
                $paths[] = $app['theme.path'].DS.'packages'.DS.$package;
            }
            $paths[] = CINCH_PACKAGES.DS.$package;
            $app['twig.loader.filesystem']->setPaths($paths, $package);
        }
    }
}
