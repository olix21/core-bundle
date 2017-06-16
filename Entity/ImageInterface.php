<?php
/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 12-08-16
 * Time: 18:45
 */

namespace Dywee\CoreBundle\Entity;

use Dywee\CoreBundle\Model\PersistableInterface;
use Symfony\Component\HttpFoundation\File\File;

interface ImageInterface extends PersistableInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Name
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment);

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return ImageInterface
     */
    public function setImageFile(File $image = null);

    public function getImageFile();

    public function setImageName($imageName);

    public function getImageName();
}