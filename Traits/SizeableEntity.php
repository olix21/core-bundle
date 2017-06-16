<?php

namespace Dywee\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;


trait SizeableEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    private $height;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $sizeUnit;

    /**
     * Set length
     *
     * @param string $length
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set sizeUnit
     *
     * @param string $sizeUnit
     * @return $this
     */
    public function setSizeUnit($sizeUnit)
    {
        $this->sizeUnit = $sizeUnit;

        return $this;
    }

    /**
     * Get sizeUnit
     *
     * @return string
     */
    public function getSizeUnit()
    {
        return $this->sizeUnit;
    }


}
