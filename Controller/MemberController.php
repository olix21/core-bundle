<?php

namespace Dywee\CoreBundle\Controller;


use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\DashboardBuilderEvent;
use Dywee\CoreBundle\Event\NavbarBuilderEvent;
use Dywee\CoreBundle\Event\SidebarBuilderEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends Controller
{
    /**
     * @Route(name="dywee_admin_homepage", path="/admin")  // route name deprecated
     * @Route(name="admin_dashboard", path="/admin")
     * @Route(name="admin", path="/admin")
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function dashboardAction()
    {
        $event = new DashboardBuilderEvent(['boxes' => [], 'cards' => []], $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_MEMBER_DASHBOARD, $event);

        return $this->render('DyweeCoreBundle:Admin:dashboard.html.twig', [
            'dashboard' => $event->getDasboard(),
            'js'        => $event->getJs()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function navbarAction()
    {
        $event = new NavbarBuilderEvent([], $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_MEMBER_NAVBAR, $event);

        return $this->render('DyweeCoreBundle:Admin:navbar.html.twig', ['navbar' => $event->getNavbar()]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * TODO bloquer l'accès si pas connecté ou pas les droits admin
     */
    public function sidebarAction()
    {
        $sidebar = [
            'admin'      => [
                [
                    'type'  => 'header',
                    'label' => 'main navigation'
                ],
                [
                    'icon'  => 'fa fa-home',
                    'label' => 'Accueil',
                    'route' => $this->generateUrl('admin_dashboard')
                ],
            ],
            'superAdmin' => [
                [
                    'type'  => 'header',
                    'label' => 'super admin'
                ]
            ]
        ];

        $event = new SidebarBuilderEvent($sidebar, $this->getUser());

        $this->get('event_dispatcher')->dispatch(DyweeCoreEvent::BUILD_MEMBER_SIDEBAR, $event);

        return $this->render('DyweeCoreBundle:Admin:sidebar.html.twig', ['sidebar' => $event->getSidebar()]);
    }
}
