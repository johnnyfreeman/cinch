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

use Cinch\Events as CinchEvents;
use Cinch\Event\FilterAppEvent;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Monolog integration for Cinch
 */
class PackageServiceProvider implements ServiceProviderInterface
{
	public function __construct($autoloader)
	{
		$this->_autoloader = $autoloader;
	}

    public function register(Application $app)
    {
		// load enabled packages
		$app['active_packages'] = Yaml::parse(file_get_contents(CINCH_APP.DS.'config'.DS.ltrim('packages.yml', DS)));

		$app['packages'] = $app->share(function($app) {

			$packages = array();

			foreach ($app['active_packages'] as $package_name) {
				// register package with autoloader
				$this->_autoloader->add($package_name, CINCH_PACKAGES.DS.$package_name);
				// resolve package bootstrap classname
				$package_classname = $package_name.'\\'.$package_name;
				// instantiate if it exists
				if (class_exists($package_classname)) {
					$packages[$package_name] = new $package_classname($app);
				}
			}

			return $packages;
		});

		$app->trigger(CinchEvents::PACKAGES_REGISTERED, new FilterAppEvent($app));
    }

    public function boot(Application $app)
    {
    	// purposefully empty

    	// packages control at what point
    	// they should be booted
    }
}
