<?php

namespace Dywee\CoreBundle\Service;

use Symfony\Component\Routing\RouterInterface;

class AdminSidebarHandler
{
    /** @var RouterInterface  */
    private $router;

    /**
     * AdminSidebarHandler constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getSideBarMenuElement()
    {
        $menu = array(
            'key' => 'core',
            'icon' => 'fa fa-user',
            'label' => 'core.sidebar.super_admin',
            'route' => $this->router->generate('admin_dashboard')
        );

        return $menu;
    }
}