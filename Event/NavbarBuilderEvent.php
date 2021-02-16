<?php

namespace Dywee\CoreBundle\Event;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class NavbarBuilderEvent extends Event
{
    /** @var array */
    protected $content;

    /** @var UserInterface */
    protected $user;

    /**
     * AdminNavbarBuilderEvent constructor.
     *
     * @param               $content
     * @param UserInterface $user
     */
    public function __construct(array $content, UserInterface $user)
    {
        $this->content = $content;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getNavbar()
    {
        return $this->content;
    }

    /**
     * @param $element
     *
     * @return $this
     */
    public function addElement($element)
    {
        $this->content[$element['key']] = $element['content'];

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
