<?php

namespace Smile\Bundle\SimplePageViewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

 /**
 * @author    Florian Touya <fltou@smile.fr>
 * @copyright 2015 Smile (http://www.smile.fr)
 *
 * @ORM\Entity(repositoryClass="Smile\Bundle\SimplePageViewBundle\Entity\Repository\PageViewStatRepository")
 * @ORM\Table(name="smile_page_view_stats")
 */
class PageViewStat
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
     * @ORM\Column(type="string", length=50, name="page_type")
     */
    private $pageType;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, name="page_id")
     */
    private $pageId;

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
    public function getPageType()
    {
        return $this->pageType;
    }

    /**
     * @param string $pageType
     *
     * @return this
     */
    public function setPageType($pageType)
    {
        $this->pageType = $pageType;

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
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @param integer $pageId
     *
     * @return this
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;

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
}
