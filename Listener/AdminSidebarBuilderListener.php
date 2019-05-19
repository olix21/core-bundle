<?php

namespace Dywee\CoreBundle\Listener;

use Dywee\CoreBundle\Service\AdminSidebarHandler;
use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\SidebarBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AdminSidebarBuilderListener implements EventSubscriberInterface
{
    /** @var AdminSidebarHandler  */
    private $adminSidebarHandler;

    /**
     * AdminSidebarBuilderListener constructor.
     *
     * @param AdminSidebarHandler $adminSidebarHandler
     */
    public function __construct(AdminSidebarHandler $adminSidebarHandler)
    {
        $this->adminSidebarHandler = $adminSidebarHandler;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            DyweeCoreEvent::BUILD_MEMBER_SIDEBAR => ['addElementToSidebar', -100]
        ];
    }

    /**
     * @param SidebarBuilderEvent $adminSidebarBuilderEvent
     */
    public function addElementToSidebar(SidebarBuilderEvent $adminSidebarBuilderEvent)
    {
        $adminSidebarBuilderEvent->addElement($this->adminSidebarHandler->getSideBarMenuElement());
    }
}
