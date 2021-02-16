<?php

declare(strict_types=1);


namespace Dywee\CoreBundle\Controller;


trait Referer
{
    private function getRefererParams()
    {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));

        return $this->get('router')->getMatcher()->match($lastPath);
    }
}
