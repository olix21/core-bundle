<?php

namespace Dywee\CoreBundle\Controller;

use Dywee\AddressBundle\Entity\Country;
use Dywee\CMSBundle\Entity\Page;
use Dywee\ProductBundle\Entity\Image;
use Dywee\SocialBundle\Entity\SocialItem;
use Dywee\WebsiteBundle\Entity\Website;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class InstallController extends Controller
{
    public function installAction()
    {
        $em = $this->getDoctrine()->getManager();

        $this->installCMS();

        return $this->redirect($this->generateUrl('dywee_cms_homepage'));
    }

    public function installCMSAction($callback = null)
    {
        $em = $this->getDoctrine()->getManager();

        $page = new Page();
        $page->setType(1);
        $page->setState(1);
        $page->setMenuName('Accueil');
        $page->setName('Accueil');
        $page->setActive(1);
        $page->setInMenu(1);
        $page->setMenuOrder(1);
        $page->setTemplate('index');

        $page->setContent('<p>Site en construction, restez à l\'écoute</p>');
        $page->setInMenu(true);
        $page->setActive(true);

        $em->persist($page);
        $em->flush();

        if($callback)
            return $this->forward($callback);
    }
}
