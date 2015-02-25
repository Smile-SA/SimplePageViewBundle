<?php

namespace Smile\Bundle\SimpleTrackingBundle\Tests\Command;

use Smile\Bundle\SimpleTrackingBundle\Command\TrackingDataUpdateCommand;
use Smile\Bundle\SimpleTrackingBundle\Entity\Track;
use Smile\Bundle\SimpleTrackingBundle\Entity\TrackCount;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class TrackingDataUpdateCommandTest
 *
 * @package Smile\Bundle\SimpleTrackingBundle\Tests\Command
 * @author Maxime Guilloreau <maxgu@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingDataUpdateCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Text Command execution
     */
    public function testExecute()
    {
        $manager = $this->getMockBuilder('\Smile\Bundle\SimpleTrackingBundle\Manager\TrackingManager')
            ->disableOriginalConstructor()
            ->getMock();

        $manager
            ->expects($this->any())
            ->method('getAllTypeTrackIdAndDate')
            ->will($this->returnValue($this->getMockTracks()));

        $manager
            ->expects($this->at(10))
            ->method('getTrackCountByType')
            ->will($this->returnValue($this->getMockTrackCount()));

        $manager
            ->expects($this->any())
            ->method('countTracks')
            ->will($this->returnValue(10));

        $manager
            ->expects($this->at(10))
            ->method('save')
            ->will($this->returnValue(null));

        $manager
            ->expects($this->once())
            ->method('removeTracks');

        $logger = $this->getMockBuilder('\Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new TrackingDataUpdateCommand($manager, $logger));

        $command = $application->find('smile:tracking:update');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array());
    }

    /**
     * Mock tracks data
     * @return Track
     */
    public function getMockTracks(){

        $tracks = array();
        for ($i = 0; $i < 10; $i++) {
            $track['id'] = $i + 1;
            $track['date'] = new \DateTime();
            $track['time'] = new \DateTime();
            $track['trackId'] = 1;
            $track['type'] = 'page1';

            $tracks[] = $track;
        }

        return $tracks;
    }

    public function getMockTrackCount()
    {
        $trackCount = new TrackCount();
        $trackCount->setId(1);
        $trackCount->setTime(new \DateTime());
        $trackCount->setDate(new \DateTime());
        $trackCount->setType('page1');
        $trackCount->setTrackId(1);
        $trackCount->setCount(10);

        return $trackCount;
    }

}