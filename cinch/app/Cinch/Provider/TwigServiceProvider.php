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
        $app['twig.loader.filesystem']->addPath($app['theme_path']);
        
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
        // $packages = Yaml::parse(file_get_contents(CINCH_APP.DS.'config'.DS.'packages.yml'));
        // foreach ($app['packages'] as $package) {
        //     $app['twig.loader.filesystem']->addPath(array(
        //             // add a place for theme developers to override package templates
        //             $app['theme_path'].DS.'packages'.DS.$package['name'], 
        //             $package['template_dir']
        //         ), 
        //         // namespace for this package's templates
        //         $package['name']
        //     );
        // }
    }
}
