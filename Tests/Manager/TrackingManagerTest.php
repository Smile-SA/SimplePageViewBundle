<?php

namespace Smile\Bundle\SimpleTrackingBundle\Tests\Manager;

use Smile\Bundle\SimpleTrackingBundle\Manager\TrackingManager;

/**
 * Class TrackingManagerTest
 *
 * @package Smile\Bundle\SimpleTrackingBundle\Tests\Manager
 * @author Maxime Guilloreau <maxgu@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getTracksMock()
    {
        $trackRepository = $this->getMockBuilder('\Smile\Bundle\SimpleTrackingBundle\Entity\Repository\TrackRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $trackRepository
            ->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue(array(1,2,3)));

        $trackCountRepository = $this->getMockBuilder('\Smile\Bundle\SimpleTrackingBundle\Entity\Repository\TrackCountRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $trackCountRepository
            ->expects($this->any())
            ->method('countTrackCountByTypeAndTrackId')
            ->will($this->onConsecutiveCalls(array(array(1 => 156)), false));

        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->onConsecutiveCalls($trackRepository, $trackCountRepository));

        return $entityManager;
    }

    /**
     * Test getTracks method
     */
    public function testMockRepository()
    {
        $manager = new TrackingManager($this->getTracksMock());
        $this->assertEquals(array(1,2,3), $manager->getTracks());
    }

    /**
     * Test return of countTrackCountByTypeAndTrackId method
     */
    public function testCountTrackRepository()
    {
        $manager = new TrackingManager($this->getTracksMock());
        $this->assertEquals(156, $manager->countTrackCountByTypeAndTrackId(null, null, null));
        $this->assertEquals(0, $manager->countTrackCountByTypeAndTrackId(null, null, null));
    }
}