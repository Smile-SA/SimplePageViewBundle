<?php

namespace Smile\Bundle\SimplePageViewBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PageViewControllerTest
 *
 * @package Smile\Bundle\SimplePageViewBundle\Test\Controller
 * @author Maxime Guilloreau <maxgu@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewControllerTest extends WebTestCase
{
    public function testPersistAction()
    {
        $client = static::createClient();

        $client->request('GET', '/page-view/page1/1');

        $this->assertInstanceOf(
            'Smile\Bundle\SimplePageViewBundle\Http\TransparentPixelResponse',
            $client->getResponse()
        );
    }

}