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

/**
* Cinch's events
*/
final class Events
{
	/**
     * The cinch.filter_content event is triggered right 
     * after a page's content is retrieved but before 
     * it is sent to the browser.
     * 
     * The event listener receives an
     * Cinch\Event\FilterContentEvent instance.
     * 
     * @var string
     */
	const PACKAGES_REGISTERED = 'cinch.packages_registered';
     const APP_BOOTED = 'cinch.app_booted';
     const CONTENT_PARSED = 'cinch.content_parsed';
     const REGION_RENDERED = 'cinch.region_rendered';
     const APP_SHUTDOWN = 'cinch.app_shutdown';
}