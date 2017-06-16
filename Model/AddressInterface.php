<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 6/08/16
 * Time: 10:42
 */
namespace Dywee\CoreBundle\Model;

use Dywee\AddressBundle\Entity\Address;
use Dywee\AddressBundle\Entity\CityInterface;
use Dywee\AddressBundle\Entity\Country;
use Dywee\AddressBundle\Entity\Email;
use Dywee\AddressBundle\Entity\PhoneNumberInterface;
use Dywee\CoreBundle\Model\PersistableInterface;


interface AddressInterface extends PersistableInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Address
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Address
     */
    public function setCompany($company);

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany();

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Address
     */
    public function setFirstName($firstName);

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Address
     */
    public function setLastName($lastName);

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set line1
     *
     * @param string $line1
     *
     * @return Address
     */
    public function setLine1($line1);

    /**
     * Get line1
     *
     * @return string
     */
    public function getLine1();

    /**
     * Set line2
     *
     * @param string $line2
     *
     * @return Address
     */
    public function setLine2($line2);

    /**
     * Get line2
     *
     * @return string
     */
    public function getLine2();


    /**
     * Set instruction
     *
     * @param string $instruction
     *
     * @return Address
     */
    public function setInstruction($instruction);

    /**
     * Get instruction
     *
     * @return string
     */
    public function getInstruction();

    /**
     * Set city
     *
     * @param CityInterface $city
     *
     * @return Address
     */
    public function setCity(CityInterface $city = null);

    /**
     * Get city
     *
     * @return CityInterface
     */
    public function getCity();

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Address
     */
    public function setNumber($number);

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber();

    /**
     * Set box
     *
     * @param string $box
     *
     * @return Address
     */
    public function setBox($box);

    /**
     * Get box
     *
     * @return string
     */
    public function getBox();

    /**
     * @param Email email
     * @return $this
     */
    public function setEmail(Email $email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param PhoneNumberInterface $phone
     * @return $this
     */
    public function setPhone(PhoneNumberInterface $phone);
    /**
     * @return string
     */
    public function getPhone();

    /**
     * @return null|Country
     */
    public function getCountry();

    public function __toString();

}