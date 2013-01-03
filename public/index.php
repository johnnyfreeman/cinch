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

// Directory Separator
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Production environment setup
error_reporting(0); 
ini_set('display_errors', 0);
define('CINCH_ENV', 'PROD');

// Paths
define('CINCH_ROOT', realpath(__DIR__.DS.'..'.DS.'cinch'));
define('CINCH_APP', CINCH_ROOT.DS.'app');
define('CINCH_PACKAGES', CINCH_ROOT.DS.'packages');
define('PUBLIC_PATH', realpath(__DIR__));

// Kickoff
require_once CINCH_APP.DS.'bootstrap.php';