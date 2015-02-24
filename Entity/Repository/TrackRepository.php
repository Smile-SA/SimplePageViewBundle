<?php

namespace Smile\SimpleTrackingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 */
class TrackRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateFilter
     *
     * @return array
     */
    public function findAllTypeTrackIdAndDate($dateFilter)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.type', 't.trackId', 't.date')
            ->distinct()
            ->where('t.date < :dateFilter')
            ->setParameter('dateFilter', $dateFilter)
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param array
     *
     * @return integer
     */
    public function countTracks(array $filters)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('COUNT(t.id) AS trackCount');

        foreach ($filters as $field => $value) {
            $qb->andWhere(sprintf('t.%1$s = :%1$s', $field))
                ->setParameter($field, $value);
        }

        $result = $qb->getQuery()->getSingleResult();

        return $result['trackCount'];
    }

    /**
     * @param \DateTime $dateFilter
     */
    public function removeTracks($dateFilter)
    {
        $trackTable = $this->getEntityManager()->getClassMetadata('SmileSimpleTrackingBundle:Track')->getTableName();
        $sql        = 'DELETE FROM ' . $trackTable . ' WHERE date < :date';
        $params     = array('date' => $dateFilter->format('Y-m-d H:i:s'));

        return $this->getEntityManager()->getConnection()->executeQuery($sql, $params);
    }
}
