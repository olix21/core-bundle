<?php

namespace Dywee\CoreBundle\Event;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class AdminDashboardBuilderEvent extends Event
{
    const TYPE_CMS = 'cms';
    const TYPE_COMMERCE = 'commerce';
    const TYPE_MUSIC = 'music';

    protected $dashboard;
    protected $user;
    protected $type;
    protected $js;

    public function __construct($dashboard, UserInterface $user)
    {
        $this->dashboard = $dashboard;
        $this->user = $user;
        $this->type = self::TYPE_CMS;
        $this->js = array();
    }

    public function getDasboard()
    {
        return $this->dashboard;
    }

    public function addElement($element)
    {
        if(isset($element['key']) && array_key_exists($element['key'], $this->dashboard))
            $this->dashboard[$element['key']]['boxes'] = array_merge($this->dashboard[$element['key']]['boxes'], $element['boxes']);
        else $this->dashboard[$element['key']] = $element['boxes'];

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function addJs($js)
    {
        $this->js = array_merge($this->js, $js);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param mixed $js
     * @return AdminDashboardBuilderEvent
     */
    public function setJs($js)
    {
        $this->js[] = $js;
        return $this;
    }


}