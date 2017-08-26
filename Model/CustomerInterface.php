<?php

namespace Dywee\CoreBundle\Model;
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

}