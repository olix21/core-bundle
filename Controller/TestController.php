<?php

namespace Dywee\CoreBundle\Controller;

use Njasm\Soundcloud\SoundcloudFacade;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function testAction()
    {
        $facade = new SoundcloudFacade('e480f7c6645cff0f37bb6df9781682a2', '40e3ab38a9e7273c743c3a5f48c9ba12', $this->generateUrl('dywee_test_page2', [], true));
        $url = $facade->getAuthUrl();

        return $this->redirect($url);
        print_r($url);
        exit;

        return $this->render('DyweeCoreBundle:Test:test.html.twig');
    }

    public function test2Action()
    {
        $facade = new SoundcloudFacade('e480f7c6645cff0f37bb6df9781682a2', '40e3ab38a9e7273c743c3a5f48c9ba12');

        $code = $_GET['code'];
        $facade->codeForToken($code);

        $response = $facade->get('/me/tracks')->request();

        $soundCloudData = $response->bodyObject();

        $data = [];

        foreach ($soundCloudData as $track) {
            $data[] = [
                'id' => $track->id,
                'name' => $track->name,
                'description' => $track->description,
                'permalink' => $track->permalink_url,
                'artwork_url' => $track->artwork_url,
            ];
        }

        $form = $this->createForm($data)->add('submit', 'submit');

        return $this->render('DyweeModuleBundle:MusicGallery:soundCloudImport.html.twig', ['form' => $form->createView()]);
    }
}
