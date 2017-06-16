<?php

namespace Dywee\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;


trait WeighableEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="decimal", scale=3, nullable=true)
     */
    private $weight = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $weightUnit;


    /**
     * Set weight
     *
     * @param string $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set weightUnit
     *
     * @param string $weightUnit
     * @return $this
     */
    public function setWeightUnit($weightUnit)
    {
        $this->weightUnit = $weightUnit;

        return $this;
    }

    /**
     * Get weightUnit
     *
     * @return string
     */
    public function getWeightUnit()
    {
        return $this->weightUnit;
    }


}
