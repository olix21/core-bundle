<?php

namespace Dywee\CoreBundle\Controller;

use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\AdminDashboardBuilderEvent;
use Dywee\CoreBundle\Event\AdminNavbarBuilderEvent;
use Dywee\CoreBundle\Event\AdminSidebarBuilderEvent;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route(name="dywee_admin_homepage", path="/admin")  // route name deprecated
     * @Route(name="admin_dashboard", path="/admin")
     * @Route(name="admin", path="/admin")
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function dashboardAction()
    {
        $event = new AdminDashboardBuilderEvent(array('boxes' => [], 'cards' => []), $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_ADMIN_DASHBOARD, $event);

        return $this->render('DyweeCoreBundle:Admin:dashboard.html.twig', array(
            'dashboard' => $event->getDasboard(),
            'js' => $event->getJs()
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function navbarAction()
    {
        $event = new AdminNavbarBuilderEvent(array(), $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_ADMIN_NAVBAR, $event);

        return $this->render('DyweeCoreBundle:Admin:navbar.html.twig', array('navbar' => $event->getNavbar()));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function sidebarAction()
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

        $event = new AdminSidebarBuilderEvent($sidebar, $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_ADMIN_SIDEBAR, $event);

        return $this->render('DyweeCoreBundle:Admin:sidebar.html.twig', array('sidebar' => $event->getSidebar()));
    }
}
