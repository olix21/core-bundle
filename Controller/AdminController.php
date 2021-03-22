<?php

namespace Dywee\CoreBundle\Controller;

use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\DashboardBuilderEvent;
use Dywee\CoreBundle\Event\NavbarBuilderEvent;
use Dywee\CoreBundle\Event\SidebarBuilderEvent;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AdminController extends AbstractController
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route(name="dywee_admin_homepage", path="/admin")  // route name deprecated
     * @Route(name="admin_dashboard", path="/admin")
     * @Route(name="admin", path="/admin")
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function dashboardAction(EventDispatcherInterface $eventDispatcher)
    {
        $event = new DashboardBuilderEvent(array('boxes' => [], 'cards' => []), $this->getUser());

        $this->eventDispatcher->dispatch($event,DyweeCoreEvent::BUILD_ADMIN_DASHBOARD);

        return $this->render('@DyweeCoreBundle/Admin/dashboard.html.twig', array(
            'dashboard' => $event->getDasboard(),
            'js' => $event->getJs()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function navbarAction(EventDispatcherInterface $eventDispatcher)
    {
        $event = new NavbarBuilderEvent(array(), $this->getUser());

        $this->eventDispatcher->dispatch($event, DyweeCoreEvent::BUILD_ADMIN_NAVBAR);

        return $this->render('@DyweeCoreBundle/Admin/navbar.html.twig', array('navbar' => $event->getNavbar()));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function sidebarAction(EventDispatcherInterface $eventDispatcher)
    {
        $sidebar = array(
            'admin' => array(
                array(
                    'type' => 'header',
                    'label' => 'main navigation'
                ),
                array(
                    'icon' => 'fa fa-home',
                    'label' => 'Accueil',
                    'route' => $this->generateUrl('admin_dashboard')
                ),
            ),
            'superAdmin' => array(
                array(
                    'type' => 'header',
                    'label' => 'super admin'
                )
            )
        );

        $event = new SidebarBuilderEvent($sidebar, $this->getUser());

        $this->eventDispatcher->dispatch($event, DyweeCoreEvent::BUILD_ADMIN_SIDEBAR);

        return $this->render('@DyweeCoreBundle/Admin/sidebar.html.twig', array('sidebar' => $event->getSidebar()));
    }
}
