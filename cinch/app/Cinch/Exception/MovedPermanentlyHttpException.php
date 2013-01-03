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

use Symfony\Component\HttpKernel\Exception\HttpException;

/*
 * The Cinch MovedPermanentlyHttpException class.
 */
class MovedPermanentlyHttpException extends HttpException
{
	public $new_uri;

    public function __construct($message = null)
    {
        parent::__construct(301, $message, null, [], 0);
    }
}
