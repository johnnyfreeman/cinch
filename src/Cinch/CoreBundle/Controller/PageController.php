<?php

namespace Cinch\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cinch\CoreBundle\Events\CoreEvents;

class PageController extends Controller
{
    public function showByIdAction($id)
    {
    	// get the event dispatcher service from the DI container
    	$event = $this->get('event_dispatcher');

    	// get page row via doctrine page model
        // need to gathar ALL data to render this page (global and local).
        // once all data is gathered, hydrate the data object.
        // regions and blocks will get their data from the data object.

        // regions and blocks will also use and default template that
        // can be overridden: region.html.twig + block.html.twig

    	$event->dispatch(CoreEvents::BEFORE_PAGE_RENDERED, $page);
    	$response = $this->render('CinchPageBundle:Welcome:index.html.twig');
    	$event->dispatch(CoreEvents::AFTER_PAGE_RENDERED, $response);

        return $response;
    }
}