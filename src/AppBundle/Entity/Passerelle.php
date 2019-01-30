<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passerelle
 *
 * @ORM\Table(name="passerelle", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8C578E53D8AB44", columns={"msisdn"})})
 * @ORM\Entity
 */
class Passerelle
{
    /**
     * @var string
     *
     * @ORM\Column(name="msisdn", type="string", length=255, nullable=false)
     */
    private $msisdn;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255, nullable=false)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=false)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="regular_expression", type="string", length=255, nullable=false)
     */
    private $regularExpression;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="date_creation", type="string", length=255, nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="type_transaction", type="string", length=255, nullable=false)
     */
    private $typeTransaction;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

     /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set msisdn
     *
     * @param string $msisdn
     *
     * @return Passerelle
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;

        return $this;
    }

    /**
     * Get msisdn
     *
     * @return string
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Passerelle
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Passerelle
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set regularExpression
     *
     * @param string $regularExpression
     *
     * @return Passerelle
     */
    public function setRegularExpression($regularExpression)
    {
        $this->regularExpression = $regularExpression;

        return $this;
    }

    /**
     * Get regularExpression
     *
     * @return string
     */
    public function getRegularExpression()
    {
        return $this->regularExpression;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Passerelle
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateCreation
     *
     * @param string $dateCreation
     *
     * @return Passerelle
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return string
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set typeTransaction
     *
     * @param string $typeTransaction
     *
     * @return Passerelle
     */
    public function setTypeTransaction($typeTransaction)
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    /**
     * Get typeTransaction
     *
     * @return string
     */
    public function getTypeTransaction()
    {
        return $this->typeTransaction;
    }
}

