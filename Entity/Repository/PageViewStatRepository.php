<?php

namespace Smile\Bundle\SimplePageViewBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewStatRepository extends EntityRepository
{
    /**
     * Find an existing page view stat entity
     *
     * @param string  $pageType
     * @param integer $pageId
     * @param string  $dateFilter
     *
     * @return integer
     */
    public function findExistingStat($pageType, $pageId, $dateFilter)
    {
        $qb = $this->createQueryBuilder('pvs')
            ->where('pvs.pageType = :pageType')
            ->setParameter('pageType', $pageType);

        if ($pageId !== null) {
            $qb
                ->andWhere('pvs.pageId = :pageId')
                ->setParameter('pageId', $pageId);
        } else {
            $qb->andWhere('pvs.pageId IS NULL');
        }

        if ($dateFilter) {
            $qb->andWhere('pvs.date = :date')
                ->setParameter('date', $dateFilter);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
