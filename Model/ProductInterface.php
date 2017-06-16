<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 13/04/17
 * Time: 08:39
 */

namespace Dywee\CoreBundle\Model;
use Dywee\CoreBundle\Traits\NameableEntity;
use Dywee\ProductBundle\Entity\Brand;
use Dywee\ProductBundle\Entity\Category;
use Dywee\ProductBundle\Entity\CommentInterface;
use Dywee\ProductBundle\Entity\FeatureElement;
use Dywee\ProductBundle\Entity\ProductPicture;
use Dywee\ProductBundle\Entity\ProductStat;
use Dywee\ProductBundle\Entity\Promotion;


/**
 * Interface ProductInterface
 *
 * @package Dywee\ProductBundle\Entity
 */
interface ProductInterface
{
    const STATE_HIDDEN = 'product.state.hidden';
    const STATE_AVAILABLE = 'product.state.available';
    const STATE_NOT_AVAILABLE_ANYMORE = 'product.state.not_available';
    const STATE_AVAILABLE_SOON = 'product.state.available_soon';
    const STATE_ONLY_IN_STORE = 'product.state.only_store';
    const STATE_STOCK_EMPTY = 'product.state.stock_empty';
    const STATE_ONLY_ON_WEB = 'product.state.only_web';

    const SIZE_UNIT_MM = 'mm';
    const SIZE_UNIT_CM = 'cm';
    const SIZE_UNIT_METER = 'm';

    const WEIGHT_UNIT_GR = 'gr';
    const WEIGHT_UNIT_KG = 'kg';
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set price
     *
     * @param float $price
     *
     * @return ProductInterface
     */
    public function setPrice($price);

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set isPriceTTC
     *
     * @param boolean $isPriceTTC
     *
     * @return ProductInterface
     */
    public function setIsPriceTTC($isPriceTTC);

    /**
     * Get isPriceTTC
     *
     * @return boolean
     */
    public function getIsPriceTTC();

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return ProductInterface
     */
    public function setStock($stock);

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock();

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return ProductInterface
     */
    public function setState($state);

    /**
     * Get state
     *
     * @return integer
     */
    public function getState();

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return ProductInterface
     */
    public function setShortDescription($shortDescription);

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription();

    /**
     * Set mediumDescription
     *
     * @param string $mediumDescription
     *
     * @return ProductInterface
     */
    public function setMediumDescription($mediumDescription);

    /**
     * Get mediumDescription
     *
     * @return string
     */
    public function getMediumDescription();

    /**
     * Set longDescription
     *
     * @param string $longDescription
     *
     * @return ProductInterface
     */
    public function setLongDescription($longDescription);

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription();

    /**
     * Set brand
     *
     * @param Brand $brand
     *
     * @return ProductInterface
     */
    public function setBrand(Brand $brand = null);

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand();

    /**
     * Add categories
     *
     * @param Category $category
     *
     * @return ProductInterface
     */
    public function addCategory(Category $category);

    /**
     * Remove categories
     *
     * @param Category $category
     */
    public function removeCategory(Category $category);

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories();

    /**
     * @param $locale
     *
     * @return ProductInterface
     */
    public function setTranslatableLocale($locale);

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeatures();

    /**
     * Add feature
     *
     * @param FeatureElement $feature
     *
     * @return ProductInterface
     */
    public function addFeature(FeatureElement $feature);

    /**
     * Remove feature
     *
     * @param FeatureElement $feature
     */
    public function removeFeature(FeatureElement $feature);

    /**
     * @return int
     */
    public function countCategories();

    /**
     * @param int $data
     *
     * @return mixed
     */
    public function getCategory($data);

    /**
     * Set stockWarningThreshold
     *
     * @param integer $stockWarningThreshold
     *
     * @return ProductInterface
     */
    public function setStockWarningThreshold($stockWarningThreshold);

    /**
     * Get stockWarningThreshold
     *
     * @return integer
     */
    public function getStockWarningThreshold();

    /**
     * Set stockAlertThreshold
     *
     * @param integer $stockAlertThreshold
     *
     * @return ProductInterface
     */
    public function setStockAlertThreshold($stockAlertThreshold);

    /**
     * Get stockAlertThreshold
     *
     * @return integer
     */
    public function getStockAlertThreshold();

    /**
     * Set availableAt
     *
     * @param \DateTime $availableAt
     *
     * @return ProductInterface
     */
    public function setAvailableAt($availableAt);

    /**
     * Get availableAt
     *
     * @return \DateTime
     */
    public function getAvailableAt();

    /**
     * Add productStat
     *
     * @param ProductStat $productStat
     *
     * @return ProductInterface
     */
    public function addProductStat(ProductStat $productStat);

    /**
     * Remove productStat
     *
     * @param ProductStat $productStat
     */
    public function removeProductStat(ProductStat $productStat);

    /**
     * Get productStats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductStats();

    /**
     * @param $quantity
     *
     * @return ProductInterface
     */
    public function decreaseStock($quantity);

    /**
     * @param $quantity
     *
     * @return ProductInterface
     */
    public function refundStock($quantity);

    /**
     * @param $quantity
     * @param $operation
     *
     * @return ProductInterface
     */
    public function stockOperation($quantity, $operation = 'decrease');

    public function getDeletedAt();

    /**
     * @param \DateTime $deletedAt
     * @return ProductInterface
     */
    public function setDeletedAt(\DateTime $deletedAt);

    public function addPicture(ProductPicture $picture);

    public function getPictures();

    public function removePicture(ProductPicture $picture);

    /**
     * Add related product
     *
     * @param ProductInterface $product
     *
     * @return ProductInterface
     */
    public function addRelatedProduct(ProductInterface $product);

    /**
     * Remove related product
     *
     * @param ProductInterface $product
     */
    public function removeRelatedProduct(ProductInterface $product);

    /**
     * Get related products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRelatedProducts();

    /**
     * @param ProductInterface $product
     *
     * @return ProductInterface
     */
    public function setRelatedToProduct(ProductInterface $product);

    /**
     * @return ProductInterface
     */
    public function getRelatedToProduct();

    public function getUrl();

    public function getMainPicture();

    /**
     * @return mixed
     */
    public function getComments();

    /**
     * @param CommentInterface $comment
     *
     * @return ProductInterface
     */
    public function addComment(CommentInterface $comment);

    public function removeComment(CommentInterface $comment);

    public function addPromotion(Promotion $promotion);

    public function getPromotions();

    public function removePromotion(Promotion $promotion);

    public function getActivePromotion();

    public function isInPromotion();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return NameableEntity
     */
    public function setName($name);

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return ProductInterface
     */
    public function setMetaTitle($metaTitle);

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle();

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return ProductInterface
     */
    public function setMetaDescription($metaDescription);

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription();

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return ProductInterface
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords();

    /**
     * Set seoUrl
     *
     * @param string $seoUrl
     *
     * @return ProductInterface
     */
    public function setSeoUrl($seoUrl);

    /**
     * Get seoUrl
     *
     * @return string
     */
    public function getSeoUrl();

    /**
     * Set length
     *
     * @param string $length
     *
     * @return ProductInterface
     */
    public function setLength($length);

    /**
     * Get length
     *
     * @return string
     */
    public function getLength();

    /**
     * Set width
     *
     * @param string $width
     *
     * @return ProductInterface
     */
    public function setWidth($width);

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth();

    /**
     * Set height
     *
     * @param string $height
     *
     * @return ProductInterface
     */
    public function setHeight($height);

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight();

    /**
     * Set sizeUnit
     *
     * @param string $sizeUnit
     *
     * @return ProductInterface
     */
    public function setSizeUnit($sizeUnit);

    /**
     * Get sizeUnit
     *
     * @return string
     */
    public function getSizeUnit();

    /**
     * Sets createdAt.
     *
     * @param  \DateTime $createdAt
     *
     * @return ProductInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets updatedAt.
     *
     * @param  \DateTime $updatedAt
     *
     * @return ProductInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Set weight
     *
     * @param string $weight
     *
     * @return ProductInterface
     */
    public function setWeight($weight);

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight();

    /**
     * Set weightUnit
     *
     * @param string $weightUnit
     *
     * @return ProductInterface
     */
    public function setWeightUnit($weightUnit);

    /**
     * Get weightUnit
     *
     * @return string
     */
    public function getWeightUnit();

    /**
     * @return bool
     */
    public function isVirtual();
}