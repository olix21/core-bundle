<?php

namespace Dywee\CoreBundle\Model;
use CompositionBundle\Entity\GlobalMusicSheet;
use Dywee\AddressBundle\Entity\Address;

/**
 * Interface CustomerAwareInterface
 *
 * @package Dywee\CoreBundle\Model
 * @author Olivier Delbruyère
 */
interface CustomerInterface
{
    const UNKNOWN_GENDER = 'u';
    const GENDER_MALE = 'm';
    const GENDER_FEMALE =  'f';

    /**
     * @return int
     */
    public function getId();

    /**
     * Add address
     *
     * @param Address $address
     *
     * @return CustomerInterface
     */
    public function addAddress(Address $address);

    /**
     * Remove address
     *
     * @param Address $address
     * @return CustomerInterface
     */
    public function removeAddress(Address $address);

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses();

    /**
     * Add musicSheetLike
     *
     * @param GlobalMusicSheet $musicSheetLike
     *
     * @return CustomerInterface
     */
    public function addMusicSheetLike(GlobalMusicSheet $musicSheetLike);

    /**
     * Remove musicSheetLike
     *
     * @param GlobalMusicSheet $musicSheetLike
     */
    public function removeMusicSheetLike(GlobalMusicSheet $musicSheetLike);

    /**
     * Get musicSheetLikes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMusicSheetLikes();

    /**
     * Add musicSheet
     *
     * @param GlobalMusicSheet $musicSheet
     *
     * @return CustomerInterface
     */
    public function addMusicSheet(GlobalMusicSheet $musicSheet);

    /**
     * Remove musicSheet
     *
     * @param GlobalMusicSheet $musicSheet
     */
    public function removeMusicSheet(GlobalMusicSheet $musicSheet);

    /**
     * Get musicSheets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMusicSheets();
}