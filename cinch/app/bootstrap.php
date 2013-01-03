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


// application setup
$app = new Application();


// // handler for AccessDeniedExceptions
// $app->error(function (AccessDeniedException $e)
// {
// 	return $app->redirect( $app->url(Cinch\Route\NamedRoutes::LOGIN));
// });

// process Request, return Response
$app->run();