<?php

namespace HelloWorld;

use Cinch\Application;
use Cinch\Package as CinchPackage;
use Cinch\Event\FilterAppEvent;

class HelloWorld extends CinchPackage {
	public function boot(FilterAppEvent $event)
	{
		echo "<pre>"; print_r($event); echo "</pre>"; die();
	}
}