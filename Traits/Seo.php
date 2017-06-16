<?php

namespace Dywee\CoreBundle\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait Seo{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaTitle", type="string", length=255, nullable = true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaDescription", type="text", nullable = true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="metaKeywords", type="text", nullable = true)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="seoUrl", type="string", length=255, nullable = true)
     */
    private $seoUrl;

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return $this
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     * @return $this
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * Get seoUrl
     *
     * @return string
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    public function getUrl()
    {
        return $this->getSeoUrl() ?? $this->getId();
    }

}