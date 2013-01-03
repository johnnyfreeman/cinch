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

/*
 * This file is the main access point (front controller) to Cinch. 
 * It is responsable for setting up the environment and a few
 * needed definitions.
 */

// development environment setup
error_reporting(-1); 
ini_set('display_errors', 1);
define('CINCH_ENV', 'DEV');

// paths
define('CINCH_ROOT', realpath(__DIR__ . '/../cinch') . DIRECTORY_SEPARATOR);
define('CINCH_APP', CINCH_ROOT . 'app' . DIRECTORY_SEPARATOR);
define('CINCH_PACKAGES', CINCH_ROOT . 'packages' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', realpath(__DIR__) . DIRECTORY_SEPARATOR);

// kickoff
require_once CINCH_APP.'bootstrap.php';