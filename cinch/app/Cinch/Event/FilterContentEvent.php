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

namespace Cinch\Event;

use Cinch\ContentProvider;
// use Symfony\Component\HttpKernel\HttpKernelInterface;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base class for events thrown in the HttpKernel component
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @api
 */
class FilterContentEvent extends Event
{
    /**
     * Content
     * @var ContentProvider
     */
    private $content;

    /**
     * 
     */
    public function __construct(ContentProvider $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content->getContent();
    }
}
