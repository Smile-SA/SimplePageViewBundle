<?php

namespace Smile\SimpleTrackingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 *
 * @ORM\Entity(repositoryClass="Smile\SimpleTrackingBundle\Entity\Repository\TrackCountRepository")
 * @ORM\Table(name="tracking_track_count")
 */
class TrackCount
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $trackId;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $count = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param integer $count
     *
     * @return this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTrackId()
    {
        return $this->trackId;
    }

    /**
     * @param integer $trackId
     *
     * @return this
     */
    public function setTrackId($trackId)
    {
        $this->trackId = $trackId;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     *
     * @return this
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;

        return $this;
    }
}
