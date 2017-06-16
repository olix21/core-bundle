<?php

namespace Dywee\CoreBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


trait NameableEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list"})
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return NameableEntity
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


}
