<?php

namespace Smile\SimpleTrackingBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Smile\SimpleTrackingBundle\Entity\Track;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingManager
{
    /** @var ObjectManager $manager */
    private $manager;

    /** @var EntityRepository $trackRepository */
    private $trackRepository;

    /** @var EntityRepository $trackCountRepository */
    private $trackCountRepository;


    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager              = $manager;
        $this->trackRepository      = $manager->getRepository('SmileSimpleTrackingBundle:Track');
        $this->trackCountRepository = $manager->getRepository('SmileSimpleTrackingBundle:TrackCount');
    }

    /**
     *
     * @return array
     */
    public function getTracks()
    {
        return $this->trackRepository->findAll();
    }

    /**
     * @param string  $type
     * @param integer $id
     */
    public function saveTrack($type, $id)
    {
        $track = new Track();
        $track->setType($type);
        $track->setTrackId($id);

        $this->manager->persist($track);
        $this->manager->flush();
    }

    public function flush()
    {
        $this->manager->flush();
    }

    /**
     * @param         $object
     * @param boolean $flush
     */
    public function save($object, $flush = false)
    {
        $this->manager->persist($object);

        if ($flush) {
            $this->manager->flush();
        }
    }

    /**
     * @param string         $type
     * @param null|integer   $trackId
     * @param null|\DateTime $date
     *
     * @return array
     */
    public function getTrackCountByType($type, $trackId = null, \DateTime $date = null)
    {
        $filters = array('type' => $type);

        if ($date) {
            $filters['date'] = $date;
        }

        if ($trackId) {
            $filters['trackId'] = $trackId;
        }

        return $this->trackCountRepository->findOneBy($filters);
    }

    /**
     * @param \DateTime $dateFilter
     */
    public function removeTracks($dateFilter)
    {
        $this->trackRepository->removeTracks($dateFilter);
    }

    /**
     * @param \DateTime $dateFilter
     *
     * @return array
     */
    public function getAllTypeTrackIdAndDate($dateFilter)
    {
        return $this->trackRepository->findAllTypeTrackIdAndDate($dateFilter);
    }

    /**
     * @param array $filters
     *
     * @return integer
     */
    public function countTracks(array $filters)
    {
        return $this->trackRepository->countTracks($filters);
    }

    /**
     * @param string  $type
     * @param integer $trackId
     * @param string  $dateFilter
     *
     * @return integer
     */
    public function countTrackCountByTypeAndTrackId($type, $trackId, $dateFilter)
    {
        $trackCount = $this->trackCountRepository->countTrackCountByTypeAndTrackId($type, $trackId, $dateFilter);

        if (isset($trackCount[0]) && isset($trackCount[0][1])) {
            return (int) $trackCount[0][1];
        }

        return 0;
    }
}
