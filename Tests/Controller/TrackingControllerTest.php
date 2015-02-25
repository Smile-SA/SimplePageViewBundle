<?php

namespace Smile\Bundle\SimpleTrackingBundle\Tests\Controller;

use Smile\Bundle\SimpleTrackingBundle\Controller\TrackingController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class TrackingControllerTest
 *
 * @package Smile\Bundle\SimpleTrackingBundle\Test\Controller
 * @author Maxime Guilloreau <maxgu@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingControllerTest extends WebTestCase
{
    public function testTrackAction()
    {
        $client = static::createClient();

        $client->request('GET', '/tracking/page1/1');

        $this->assertInstanceOf(
            'Smile\Bundle\SimpleTrackingBundle\Http\TransparentPixelResponse',
            $client->getResponse()
        );
    }

}