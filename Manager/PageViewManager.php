<?php

namespace Smile\Bundle\SimplePageViewBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Smile\Bundle\SimplePageViewBundle\Entity\PageView;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewManager
{
    /** @var ObjectManager $manager */
    private $manager;

    /** @var EntityRepository $pageViewRepository */
    private $pageViewRepository;

    /** @var EntityRepository $pageViewStatRepository */
    private $pageViewStatRepository;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager              = $manager;
        $this->pageViewRepository   = $manager->getRepository('SmileSimplePageViewBundle:PageView');
        $this->pageViewStatRepository = $manager->getRepository('SmileSimplePageViewBundle:PageViewStat');
    }

    /**
     * @param string  $type
     * @param integer $id
     */
    public function savePageView($type, $id)
    {
        $pageView = new PageView();
        $pageView->setPageType($type);
        $pageView->setPageId($id);

        $this->persist($pageView);
        $this->flush();
    }

    /**
     * Wrapper aroud doctrine persist
     *
     * @return void
     */
    public function persist($object)
    {
        $this->manager->persist($object);
    }

    /**
     * Wrapper aroud doctrine flush
     *
     * @return void
     */
    public function flush()
    {
        $this->manager->flush();
    }

    /**
     * @param \DateTime $dateFilter
     */
    public function removePageViews($dateFilter)
    {
        $this->pageViewRepository->removePageViews($dateFilter);
    }

    /**
     * @param \DateTime $dateFilter
     *
     * @return array
     */
    public function getAllTypeIdAndDate($dateFilter)
    {
        return $this->pageViewRepository->findAllTypeIdAndDate($dateFilter);
    }

    /**
     * @param array $filters
     *
     * @return integer
     */
    public function countPageViews(array $filters)
    {
        return $this->pageViewRepository->countPageViews($filters);
    }

    /**
     * @param string  $pageType
     * @param integer $pageId
     * @param string  $dateFilter
     *
     * @return PageViewStat
     */
    public function findExistingStat($pageType, $pageId, $dateFilter)
    {
        return $this->pageViewStatRepository->findExistingStat($pageType, $pageId, $dateFilter);
    }
}
