<?php

namespace Smile\Bundle\SimpleTrackingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Smile\Bundle\SimpleTrackingBundle\Http\TransparentPixelResponse;

 /**
 * @author    Florian Touya <mxdup@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 *
 * @Route("/tracking")
 */
class TrackingController extends Controller
{
    /**
     * Save Track Data at kernel event terminate
     * @Route("/{type}/{id}", name="smile_tracking_track")
     */
    public function trackAction($type, $id)
    {
        $dispatcher      = $this->get('event_dispatcher');
        $trackingManager = $this->get('smile.tracking.manager');

        $dispatcher->addListener(KernelEvents::TERMINATE,
            function (PostResponseEvent $event) use ($trackingManager, $type, $id) {
                $trackingManager->saveTrack($type, $id);
            }
        );

        return new TransparentPixelResponse();
    }
}
