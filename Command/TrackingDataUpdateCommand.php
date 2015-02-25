<?php

namespace Smile\Bundle\SimpleTrackingBundle\Command;

use Symfony\Component\Console\Command\Command;
use Smile\Bundle\SimpleTrackingBundle\Manager\TrackingManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Smile\Bundle\SimpleTrackingBundle\Entity\TrackCount;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackingDataUpdateCommand extends Command
{
    /** @var TrackingManager $manager */
    private $manager;

    /** @var InputInterface $input */
    private $input;

    /** @var OutputInterface $output */
    private $output;

    /** @var \DateTime $commandStartTime */
    private $commandStartTime;


    /**
     * @param TrackingManager $manager
     * @param LoggerInterface $logger
     */
    public function __construct(TrackingManager $manager, LoggerInterface $logger)
    {
        $this->manager          = $manager;
        $this->logger           = $logger;
        $this->commandStartTime = new \DateTime();

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('smile:tracking:update')
            ->setDescription('Update tracking data')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        try {
            $this->handleTrackCounts();
            $this->manager->removeTracks($this->commandStartTime);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return;
        }
    }

    /**
     * Get all Track Data By date and create Track count
     * @return array
     */
    public function handleTrackCounts()
    {
        $countDistinct = $this->manager->getAllTypeTrackIdAndDate($this->commandStartTime);

        foreach ($countDistinct as $fields) {
            $filters = array();

            foreach ($fields as $field => $value) {
                $filters[$field] = $value;
            }

            $trackCount = $this->manager->countTracks($filters);

            $this->saveTrackCount($trackCount, $filters);
        }

        $this->manager->flush();
    }

    /**
     * Create or Update track count
     * @param integer $count
     * @param array   $filters
     */
    public function saveTrackCount($count, $filters)
    {

        $trackCount = $this->manager->getTrackCountByType($filters['type'], $filters['trackId'], $filters['date']);

        if (!$trackCount) {
            $trackCount = new TrackCount();
        }

        $trackCount->setCount($trackCount->getCount() + $count);
        $trackCount->setDate($filters['date']);
        $trackCount->setType($filters['type']);
        $trackCount->setTrackId($filters['trackId']);

        $this->manager->save($trackCount);
    }
}
