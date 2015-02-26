<?php

namespace Smile\Bundle\SimplePageViewBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class PageViewRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateFilter
     *
     * @return array
     */
    public function findAllTypeIdAndDate($dateFilter)
    {
        $qb = $this->createQueryBuilder('pv')
            ->select('pv.pageType', 'pv.pageId', 'pv.date')
            ->distinct()
            ->where('pv.date < :dateFilter')
            ->setParameter('dateFilter', $dateFilter);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Count Page views by pageType pageId and date
     * @param array
     *
     * @return integer
     */
    public function countPageViews(array $filters)
    {
        $qb = $this->createQueryBuilder('pv')
            ->select('COUNT(pv.id) AS pageViewCount');

        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $qb->andWhere(sprintf('pv.%1$s = :%1$s', $field))
                    ->setParameter($field, $value);
            } else {
                $qb->andWhere(sprintf('pv.%1$s IS NULL', $field));
            }
        }

        $result = $qb->getQuery()->getSingleResult();

        return $result['pageViewCount'];
    }

    /**
     * Remove page view before datefilter
     *
     * @param $dateFilter
     *
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removePageViews($dateFilter)
    {
        $qb = $this->createQueryBuilder('pv')
            ->delete()
            ->where('pv.date < :date')
            ->setParameter('date', $dateFilter->format('Y-m-d H:i:s'));

        return $qb->getQuery()->getResult();
    }
}
