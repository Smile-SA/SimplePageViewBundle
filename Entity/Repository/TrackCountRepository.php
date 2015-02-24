<?php

namespace Smile\SimpleTrackingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackCountRepository extends EntityRepository
{
    /**
     * @param string  $type
     * @param integer $trackId
     * @param string  $dateFilter
     *
     * @return integer
     */
    public function countTrackCountByTypeAndTrackId($type, $trackId, $dateFilter)
    {
        $qb = $this->createQueryBuilder('t')
            ->addSelect('SUM(t.count)')
            ->where('t.type = :type')
            ->andWhere('t.trackId = :trackId')
            ->setParameters(array('type' => $type, 'trackId' => $trackId));

        if ($dateFilter) {
            $qb->andWhere('t.date > :date')
                ->setParameter('date', $dateFilter);
        }

        $qb->addGroupBy('t.type', 't.trackId');

        return $qb->getQuery()->getResult();
    }
}
