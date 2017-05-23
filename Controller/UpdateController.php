<?php

namespace Dywee\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function updateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $response = '';

        return new Response($response);
    }
}
