<?php

namespace Cinch\CoreBundle\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\Event;

/**
 * Allows to filter a Response object
 *
 * You can call getResponse() to retrieve the current response. With
 * setResponse() you can set a new response that will be returned to the
 * browser.
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony.com>
 *
 * @api
 */
class FilterResponseEvent extends Event
{
    /**
     * The current response object
     * @var Symfony\Component\HttpFoundation\Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->setResponse($response);
    }

    /**
     * Returns the current response object
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @api
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets a new response object
     *
     * @param Symfony\Component\HttpFoundation\Response $response
     *
     * @api
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
