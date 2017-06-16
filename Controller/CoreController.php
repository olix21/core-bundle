<?php

namespace Dywee\CoreBundle\Controller;

use libphonenumber\PhoneNumberUtil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Dywee\CoreBundle\Event\AdminSidebarBuilderEvent;
use Dywee\CoreBundle\DyweeCoreEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\Annotation\Route;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('cms_homepage'));
    }

    public function testMailAction()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de votre paiement')
            ->setFrom('info@dywee.com')
            ->setTo('olivier.delbruyere@hotmail.com')
            ->setBody('<p>Mail de test</p>');
        $message->setContentType("text/html");

        $this->get('mailer')->send($message);

        return new Response('mail envoyé');
    }

    /**
     * @Route(path="robots.txt")
     */
    public function robotsTxtAction()
    {
        return $this->render('DyweeCoreBundle::robots.txt.twig');

    }
}
