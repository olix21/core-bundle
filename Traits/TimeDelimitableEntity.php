<?php

namespace Dywee\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;


trait TimeDelimitableEntity
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $beginAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endAt;

    /**
     * @return \DateTime
     */
    public function getBeginAt()
    {
        return $this->beginAt;
    }

    /**
     * @param \DateTime $beginAt
     * @return TimeDelimitableEntity
     */
    public function setBeginAt($beginAt)
    {
        $this->beginAt = $beginAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param \DateTime $endAt
     * @return TimeDelimitableEntity
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getBeginDate()
    {
        return $this->beginAt;
    }

    public function setBeginDate(\DateTime $date)
    {
        $date = $date->format('Y/m/d');
        $time = $this->beginAt ? $this->beginAt->format('H:i') : '00:00';
        $this->beginAt = new \DateTime($date.' '.$time);
    }

    public function getBeginTime()
    {
        return $this->beginAt;
    }

    public function setBeginTime(\DateTime $time)
    {
        $this->beginAt = new \DateTime($this->beginAt ? $this->beginAt->format('Y/m/d') : '0000/00/00'.' '.$time->format('H:i'));
    }

    public function getEndDate()
    {
        return $this->endAt;
    }

    public function setEndDate(\DateTime $date)
    {
        $date = $date->format('Y/m/d');
        $time = $this->beginAt ? $this->beginAt->format('H:i') : '00:00';
        $this->endAt = new \DateTime($date.' '.$time);
    }

    public function getEndTime()
    {
        return $this->endAt;
    }

    public function setEndTime(\DateTime $time)
    {
        $this->endAt = new \DateTime($this->endAt ? $this->endAt->format('Y/m/d'): '0000/00/00'.' '.$time->format('H:i'));
    }

}
