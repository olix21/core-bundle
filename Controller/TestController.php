<?php

namespace Dywee\CoreBundle\Controller;

use Dywee\BlogBundle\Entity\Article;
use Dywee\CMSBundle\Entity\Page;
use Dywee\EshopBundle\Entity\Address;
use Dywee\EshopBundle\Entity\Country;
use Dywee\OrderBundle\Entity\BaseOrder;
use Dywee\OrderBundle\Entity\OrderElement;
use Dywee\ProductBundle\Entity\Category;
use Dywee\ProductBundle\Entity\Image;
use Dywee\ProductBundle\Entity\Product;
use Dywee\OrderBundle\Entity\Deliver;
use libphonenumber\PhoneNumberUtil;
use Njasm\Soundcloud\SoundcloudFacade;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function testAction()
    {
        $facade = new SoundcloudFacade('e480f7c6645cff0f37bb6df9781682a2', '40e3ab38a9e7273c743c3a5f48c9ba12', $this->generateUrl('dywee_test_page2', array(), true));
        $url = $facade->getAuthUrl();

        return $this->redirect($url);
        print_r($url); exit;
        return $this->render('DyweeCoreBundle:Test:test.html.twig');
    }

    public function test2Action()
    {
        $facade = new SoundcloudFacade('e480f7c6645cff0f37bb6df9781682a2', '40e3ab38a9e7273c743c3a5f48c9ba12');

        $code = $_GET['code'];
        $facade->codeForToken($code);

        $response = $facade->get('/me/tracks')->request();

        $soundCloudData = $response->bodyObject();

        $data = array();

        foreach($soundCloudData as $track)
        {
            $data[] = array(
                'id' => $track->id,
                'name' => $track->name,
                'description' => $track->description,
                'permalink' => $track->permalink_url,
                'artwork_url' => $track->artwork_url,
            );
        }

        $form = $this->createForm($data)->add('submit', 'submit');


        return $this->render('DyweeModuleBundle:MusicGallery:soundCloudImport.html.twig', array('form' => $form->createView()));
    }
}
