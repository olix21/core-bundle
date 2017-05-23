<?php

namespace Dywee\ContactBundle\Service;

use Symfony\Component\Routing\Router;

class AdminSidebarHandler
{
    /**
     * AdminNavbarHandler constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
    }

    /**
     * @return array
     */
    public function getDashboardElement() : array
    {
        $elements = [
            'key' => 'contact',
            'content' => [
                'icon' => 'fa-enveloppe',
                'controller' => 'DyweeContactBundle:Admin:Navbar',
            ],
        ];

        return $elements;
    }
}
