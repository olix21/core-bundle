<?php

namespace Dywee\CoreBundle\Event;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class DashboardBuilderEvent extends Event
{
    const TYPE_CMS = 'cms';
    const TYPE_COMMERCE = 'commerce';
    const TYPE_MUSIC = 'music';

    /** @var array */
    protected $dashboard;

    /** @var UserInterface */
    protected $user;

    /** @var string */
    protected $type;

    /** @var array */
    protected $js;

    /**
     * DashboardBuilderEvent constructor.
     *
     * @param               $dashboard
     * @param UserInterface $user
     */
    public function __construct(array $dashboard, UserInterface $user)
    {
        $this->dashboard = $dashboard;
        $this->user = $user;
        $this->type = self::TYPE_CMS;
        $this->js = [];
    }

    /**
     * @return mixed
     */
    public function getDasboard()
    {
        return $this->dashboard;
    }

    /**
     * @param $element
     *
     * @return $this
     */
    public function addElement(array $element)
    {
        if (array_key_exists('boxes', $element)) {
            if (array_key_exists($element['key'], $this->dashboard['boxes'])) {
                $this->dashboard['boxes'][$element['key']] = array_merge($this->dashboard['boxes'][$element['key']], $element['boxes']);
            } else {
                $this->dashboard['boxes'][$element['key']] = $element['boxes'];
            }
        }
        if (array_key_exists('cards', $element)) {
            if (array_key_exists($element['key'], $this->dashboard['cards'])) {
                $this->dashboard['cards'][$element['key']] = array_merge($this->dashboard['cards'][$element['key']], $element['cards']);
            } else {
                $this->dashboard['cards'][$element['key']] = $element['cards'];
            }
        }

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser() : UserInterface
    {
        return $this->user;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param $js
     *
     * @return $this
     */
    public function addJs($js)
    {
        $this->js = array_merge($this->js, $js);

        return $this;
    }

    /**
     * @return array
     */
    public function getJs() : array
    {
        return $this->js;
    }

    /**
     * @param mixed $js
     *
     * @return DashboardBuilderEvent
     */
    public function setJs($js)
    {
        $this->js[] = $js;

        return $this;
    }


}
