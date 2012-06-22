<?php

namespace Cinch\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Cinch\CoreBundle\CoreEvents;
use Cinch\CoreBundle\Entity\Page;
use Cinch\CoreBundle\Entity\Region;
use Cinch\CoreBundle\Entity\Block;
use Cinch\CoreBundle\Event\FilterDataEvent;
use Cinch\CoreBundle\Event\FilterResponseEvent;
use Cinch\CoreBundle\Container\DataContainer;

class PageController extends Controller
{
    public function showByIdAction($id)
    {
        //echo '<pre>'; print_r($this->container->getServiceIds()); echo '</pre>'; die();
    	// get page row via doctrine page model
        // need to gathar ALL data to render this page (global and local).
        // once all data is gathered, hydrate the data object.
        // regions and blocks will get their data from the data object.
        $page = $this->getDoctrine()->getRepository('CinchCoreBundle:Page')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('404 - Page not found.');
        }

        $data_container = $this->get('cinch.data_container');
        $data_container->setPage($page);

        // regions and blocks will also use and default template that
        // can be overridden: region.html.twig + block.html.twig

        // trigger 'before page rendered' event
        $event = $this->get('event_dispatcher');
    	$event->dispatch(CoreEvents::BEFORE_PAGE_RENDERED, new FilterDataEvent($page));

        // render page
        $response = $this->render('CinchCoreBundle:Default:index.html.twig', array(
            'page' => array( 'title' => $page->getTitle() )
        ));

        // trigger 'after page rendered' event
    	$event->dispatch(CoreEvents::AFTER_PAGE_RENDERED, new FilterResponseEvent($response));

        // return the final response
        return $response;
    }
}