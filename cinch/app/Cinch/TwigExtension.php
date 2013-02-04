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
use Exception;

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
            'region' => new Twig_Function_Method($this, 'regionFunction', array('needs_environment' => true, 'is_safe' => array('html'))),
            'block' => new Twig_Function_Method($this, 'blockFunction', array('needs_environment' => true, 'is_safe' => array('html'))),
        );
    }

    public function assetFunction(Twig_Environment $twig, $path)
    {
        $globals = $twig->getGlobals();
        $theme_url = $globals['app']['theme.url'];
        return $theme_url.DS.ltrim($path, DS);
    }

    public function regionFunction(Twig_Environment $twig, $blocks)
    {
        $region  = new Region();
        $globals = $twig->getGlobals();
        $app     = $globals['app'];
        $content = $app['content'];

        // if $blocks is a string, we need to look for 
        // the configurations in the content service
        if (is_string($blocks)) {
            $region_name = $blocks;
            $blocks      = array_key_exists($region_name, $content['regions']) 
                                ? $content['regions'][$region_name] 
                                : array();
        }

        if (!is_array($blocks)) {
            throw new Exception('$blocks should be an array by now');
        }

        foreach ($blocks as $block) {
            // instantiate blocks and store them
            $class    = $block['class'];
            $options  = $block['options'];
            $newBlock = new $class($options);

            if (false === $newBlock instanceof BlockInterface) {
                throw new \Exception('The ' . $class . ' class must implement BlockInterface');
            }

            $newBlock->setApp($globals['app']);
            $newBlock->setParentRegion($region);
            $region->addBlock($newBlock);
        }

        return $region->display();
    }

    public function blockFunction($config)
    {
        return '';
    }
}