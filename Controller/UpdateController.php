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
