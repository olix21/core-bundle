<?php

namespace Dywee\CoreBundle\Event;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class AdminSidebarBuilderEvent extends Event
{
    /** @var array $sidebar */
    protected $sidebar;

    /** @var UserInterface $user */
    protected $user;

    /**
     * AdminSidebarBuilderEvent constructor.
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
     * @return AdminSidebarBuilderEvent
     * @throws \Exception
     */
    public function addAdminElement($element) : AdminSidebarBuilderEvent
    {
        if (!is_array($element)) {
            return $this;
        }

        if (!array_key_exists('key', $element)) {
            foreach ($element as $subElement) {
                $this->addAdminElement($subElement);
            }
        } elseif (array_key_exists($element['key'], $this->sidebar['admin'])) {
            if (!array_key_exists('children', $element)) {
                throw new \Exception('no children found for key ' . $element['key']);
            }
            $this->sidebar['admin'][$element['key']]['children'] = array_merge($this->sidebar['admin'][$element['key']]['children'], $element['children']);
        } else {
            $this->sidebar['admin'][$element['key']] = $element;
        }

        return $this;
    }

    /**
     * @param array $element
     *
     * @return AdminSidebarBuilderEvent
     */
    public function addSuperAdminElement(array $element) : AdminSidebarBuilderEvent
    {
        $this->sidebar['superadmin'][] = $element;

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