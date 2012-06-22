<?php

namespace Cinch\CoreBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Symfony\Component\DependencyInjection\Container;

class CoreExtension extends Twig_Extension
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'region' => new Twig_Function_Method($this, 'regionFunction')
        );
    }

    public function regionFunction($alias)
    {
    	return $this->container->get('cinch.data_container')->getPage()->getTitle();
    }

    public function getName()
    {
        return 'core_extension';
    }
}