<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 6/08/16
 * Time: 09:58
 */
namespace Dywee\CoreBundle\Model;

interface PersistableInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();
}