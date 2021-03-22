<?php

namespace Dywee\CoreBundle\Event;

use Dywee\CoreBundle\Model\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SidebarBuilderEvent extends Event
{
    /** @var array $sidebar */
    protected $sidebar;

    /** @var UserInterface $user */
    protected $user;

    /**
     * SidebarBuilderEvent constructor.
     *
     * @param array         $sidebar
     * @param UserInterface $user
     */
    public function __construct(array $sidebar, UserInterface $user)
    {
        $this->sidebar = $sidebar;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSidebar()
    {
        return $this->sidebar;
    }

    /**
     * @param array|null $element
     *
     * @return SidebarBuilderEvent
     * @throws \Exception
     */
    public function addElement($element) : SidebarBuilderEvent
    {
        if (!is_array($element)) {
            return $this;
        }

        if (!array_key_exists('key', $element)) {
            foreach ($element as $subElement) {
                $this->addElement($subElement);
            }
        } elseif (array_key_exists($element['key'], $this->sidebar['admin'])) {
            if (!array_key_exists('children', $element)) {
                throw new \UnexpectedValueException('no children found for key ' . $element['key']);
            }
            $this->sidebar['admin'][$element['key']]['children'] = array_merge($this->sidebar['admin'][$element['key']]['children'], $element['children']);
        } else {
            $this->sidebar['admin'][$element['key']] = $element;
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
}
