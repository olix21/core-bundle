<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 7/08/16
 * Time: 20:37
 */
namespace Dywee\CoreBundle\Model;

use Dywee\ProductBundle\Entity\Category;

interface TreeInterface
{
    /**
     * Get position
     *
     * @param $locale
     * @return integer
     */
    public function setTranslatableLocale($locale);

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return Category
     */
    public function setLft($lft);

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft();

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Category
     */
    public function setLvl($lvl);

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl();

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Category
     */
    public function setRgt($rgt);

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt();

    /**
     * Set root
     *
     * @param integer $root
     *
     * @return Category
     */
    public function setRoot($root);

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot();
}