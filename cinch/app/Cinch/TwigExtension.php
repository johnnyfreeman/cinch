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

use Twig_Extension;
use Twig_Function_Method;
use Twig_Environment;
use Cinch\Region;

/*
 * The Cinch Application class.
 */
class TwigExtension extends Twig_Extension
{
    public function getName()
    {
        return 'cinch';
    }

    public function getFunctions()
    {
        return array(
            'asset' => new Twig_Function_Method($this, 'assetFunction', array('needs_environment' => true)),
            'region' => new Twig_Function_Method($this, 'regionFunction', array('needs_environment' => true)),
            'block' => new Twig_Function_Method($this, 'blockFunction', array('needs_environment' => true)),
        );
    }

    public function assetFunction(Twig_Environment $twig, $path)
    {
        $globals = $twig->getGlobals();
        $theme_url = $globals['app']['theme_url'];
        return $theme_url . '/' . ltrim($path, '/');
    }

    public function regionFunction(Twig_Environment $twig, $blocks)
    {
        $region = new Region();

        foreach ($blocks as $config) {
            $region->addBlock($config);
        }

        return $region;
    }

    public function blockFunction(Twig_Environment $twig, $path)
    {
        return '';
    }
}