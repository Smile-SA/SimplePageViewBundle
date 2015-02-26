<?php

namespace Smile\Bundle\SimplePageViewBundle\Command;

use Symfony\Component\Console\Command\Command;
use Smile\Bundle\SimplePageViewBundle\Manager\PageViewManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Smile\Bundle\SimplePageViewBundle\Entity\PageViewStat;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewDataAggregateCommand extends Command
{
    /** @var PageViewManager $manager */
    private $manager;

    /** @var InputInterface $input */
    private $input;

    /** @var OutputInterface $output */
    private $output;

    /** @var \DateTime $commandStartTime */
    private $commandStartTime;


    /**
     * @param PageViewManager $manager
     * @param LoggerInterface $logger
     */
    public function __construct(PageViewManager $manager, LoggerInterface $logger)
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
            ->setName('smile:pageviews:aggregate')
            ->setDescription('Update page view aggregated data')
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
            $this->handlePageViewCounts();
            $this->manager->removePageViews($this->commandStartTime);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return;
        }
    }

    /**
     * Get all Page View Data By date and create aggregation count
     *
     * @return array
     */
    public function handlePageViewCounts()
    {
        $countDistinct = $this->manager->getAllTypeIdAndDate($this->commandStartTime);

        foreach ($countDistinct as $fields) {
            $filters = array();

            foreach ($fields as $field => $value) {
                $filters[$field] = $value;
            }

            $pageViewCount = $this->manager->countPageViews($filters);

            $this->savePageViewCount((int) $pageViewCount, $filters);
        }

        $this->manager->flush();
    }

    /**
     * Create or Update page view count
     * @param integer $count
     * @param array   $filters
     */
    public function savePageViewCount($count, $filters)
    {
        if ($count === 0) {
            return;
        }

        $pageViewStat = $this->manager->findExistingStat($filters['pageType'], $filters['pageId'], $filters['date']);

        if (!$pageViewStat) {
            $pageViewStat = new PageViewStat();
        }

        $pageViewStat->setCount($pageViewStat->getCount() + $count);
        $pageViewStat->setDate($filters['date']);
        $pageViewStat->setPageType($filters['pageType']);
        $pageViewStat->setPageId($filters['pageId']);

        $this->manager->persist($pageViewStat);
    }
}
