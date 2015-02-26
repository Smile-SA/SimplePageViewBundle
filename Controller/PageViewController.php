<?php

namespace Smile\Bundle\SimplePageViewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Smile\Bundle\SimplePageViewBundle\Http\TransparentPixelResponse;

 /**
 * @author    Florian Touya <mxdup@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 *
 * @Route("/page-view")
 */
class PageViewController extends Controller
{
    /**
     * Save Page View Data at kernel event terminate
     *
     * @Route("/{type}/{id}", name="smile_page_view_persist", defaults={"id" = null})
     */
    public function persistAction($type, $id)
    {
        $dispatcher      = $this->get('event_dispatcher');
        $pageViewManager = $this->get('smile.page_view.manager');

        $dispatcher->addListener(KernelEvents::TERMINATE,
            function (PostResponseEvent $event) use ($pageViewManager, $type, $id) {
                $pageViewManager->savePageView($type, $id);
            }
        );

        return new TransparentPixelResponse();
    }
}
