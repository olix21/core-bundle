<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 7/08/16
 * Time: 20:37.
 */

namespace Dywee\CoreBundle\Model;

use Dywee\ProductBundle\Entity\Category;

interface TreeInterface
{
    /**
     * Get position.
     *
     * @param $locale
     *
     * @return int
     */
    public function setTranslatableLocale($locale);

    /**
     * Set lft.
     *
     * @param int $lft
     *
     * @return Category
     */
    public function setLft($lft);

    /**
     * Get lft.
     *
     * @return int
     */
    public function getLft();

    /**
     * Set lvl.
     *
     * @param int $lvl
     *
     * @return Category
     */
    public function setLvl($lvl);

    /**
     * Get lvl.
     *
     * @return int
     */
    public function getLvl();

    /**
     * Set rgt.
     *
     * @param int $rgt
     *
     * @return Category
     */
    public function setRgt($rgt);

    /**
     * Get rgt.
     *
     * @return int
     */
    public function getRgt();

    /**
     * Set root.
     *
     * @param int $root
     *
     * @return Category
     */
    public function setRoot($root);

    /**
     * Get root.
     *
     * @return int
     */
    public function getRoot();
}
