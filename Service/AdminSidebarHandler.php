<?php

namespace Dywee\CoreBundle\Service;

use Symfony\Component\Routing\Router;

class AdminSidebarHandler
{
    /** @var Router  */
    private $router;

    /**
     * AdminSidebarHandler constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
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