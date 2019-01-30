<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transactions
 *
 * @ORM\Table(name="transactions", indexes={@ORM\Index(name="passerelle_abaccount_index", columns={"passerelle_id", "abaccount_id"}), @ORM\Index(name="abaccount_id", columns={"abaccount_id"}), @ORM\Index(name="IDX_EAA81A4CEBCA6F32", columns={"passerelle_id"})})
 * @ORM\Entity
 */
class Transactions
{
    /**
     * @var string
     *
     * @ORM\Column(name="email_sender", type="string", length=255, nullable=true)
     */
    private $emailSender;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255, nullable=true)
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="email_recipient", type="string", length=255, nullable=false)
     */
    private $emailRecipient;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn_sender", type="string", length=255, nullable=false)
     */
    private $msisdnSender;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255, nullable=false)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn_recipient", type="string", length=255, nullable=false)
     */
    private $msisdnRecipient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_transfert", type="date", nullable=true)
     */
    private $dateTransfert;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=false)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_url", type="string", length=255, nullable=false)
     */
    private $redirectUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="id_sms", type="string", length=255, nullable=true)
     */
    private $idSms;

    /**
     * @var integer
     *
     * @ORM\Column(name="fees", type="float", nullable=true)
     */
    private $fees;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reception_sms", type="date", nullable=true)
     */
    private $dateReceptionSms;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_ttc", type="float", precision=10, scale=0, nullable=false)
     */
    private $amountTtc;

    /**
     * @var string
     *
     * @ORM\Column(name="type_operation", type="string", length=255, nullable=false)
     */
    private $typeOperation;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=false)
     */
    private $state;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount_received", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalAmountReceived;

    /**
     * @var float
     *
     * @ORM\Column(name="delta_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $deltaAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Passerelle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Passerelle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="passerelle_id", referencedColumnName="id")
     * })
     */
    private $passerelle;

    /**
     * @var \AppBundle\Entity\Abaccount
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Abaccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="abaccount_id", referencedColumnName="id")
     * })
     */
    private $abaccount;

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
     * Set emailSender
     *
     * @param string $emailSender
     *
     * @return Transaction
     */
    public function setEmailSender($emailSender)
    {
        $this->emailSender = $emailSender;

        return $this;
    }

    /**
     * Get emailSender
     *
     * @return string
     */
    public function getEmailSender()
    {
        return $this->emailSender;
    }


    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Transaction
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set emailRecipient
     *
     * @param string $emailRecipient
     *
     * @return Transaction
     */
    public function setEmailRecipient($emailRecipient)
    {
        $this->emailRecipient = $emailRecipient;

        return $this;
    }

    /**
     * Get emailRecipient
     *
     * @return string
     */
    public function getEmailRecipient()
    {
        return $this->emailRecipient;
    }

    /**
     * Set msisdnSender
     *
     * @param string $msisdnSender
     *
     * @return Transaction
     */
    public function setMsisdnSender($msisdnSender)
    {
        $this->msisdnSender = $msisdnSender;

        return $this;
    }

    /**
     * Get msisdnSender
     *
     * @return string
     */
    public function getMsisdnSender()
    {
        return $this->msisdnSender; 
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Transaction
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
     * Set msisdnRecipient
     *
     * @param string $msisdnRecipient
     *
     * @return Transaction
     */
    public function setMsisdnRecipient($msisdnRecipient)
    {
        $this->msisdnRecipient = $msisdnRecipient;

        return $this;
    }

    /**
     * Get msisdnRecipient
     *
     * @return string
     */
    public function getMsisdnRecipient()
    {
        return $this->msisdnRecipient;
    }

    /**
     * Set dateTransfert
     *
     * @param \DateTime $dateTransfert
     *
     * @return Transaction
     */
    public function setDateTransfert($dateTransfert)
    {
        $this->dateTransfert = $dateTransfert;

        return $this;
    }

    /**
     * Get dateTransfert
     *
     * @return \DateTime
     */
    public function getDateTransfert()
    {
        return $this->dateTransfert;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     *
     * @return Transaction
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set redirectUrl
     *
     * @param string $redirectUrl
     *
     * @return Transaction
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * Get redirectUrl
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Set idSms
     *
     * @param string $idSms
     *
     * @return Transaction
     */
    public function setIdSms($idSms)
    {
        $this->idSms = $idSms;

        return $this;
    }

    /**
     * Get idSms
     *
     * @return string
     */
    public function getIdSms()
    {
        return $this->idSms;
    }

    /**
     * Set fees
     *
     * @param float $fees
     *
     * @return Transaction
     */
    public function setFees($fees)
    {
        $this->fees = $fees;

        return $this;
    }

    /**
     * Get fees
     *
     * @return float
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Set dateReceptionSMS
     *
     * @param \DateTime $dateReceptionSMS
     *
     * @return Transaction
     */
    public function setDateReceptionSMS($dateReceptionSms)
    {
        $this->dateReceptionSms = $dateReceptionSms;

        return $this;
    }

    /**
     * Get dateReceptionSMS
     *
     * @return \DateTime
     */
    public function getDateReceptionSMS()
    {
        return $this->dateReceptionSms;
    }


    /**
     * Set amountTTC
     *
     * @param float $amountTTC
     *
     * @return Transaction
     */
    public function setAmountTTC($amountTtc)
    {
        $this->amountTtc = $amountTtc;

        return $this;
    }

    /**
     * Get amountTTC
     *
     * @return float
     */
    public function getAmountTTC()
    {
        return $this->amountTtc;
    }

    /**
     * Set typeOperation
     *
     * @param string $typeOperation
     *
     * @return Transaction
     */
    public function setTypeOperation($typeOperation)
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    /**
     * Get typeOperation
     *
     * @return string
     */
    public function getTypeOperation()
    {
        return $this->typeOperation;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Transaction
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
     * Set totalAmountReceived
     *
     * @param float $totalAmountReceived
     *
     * @return Transaction
     */
    public function setTotalAmountReceived($totalAmountReceived)
    {
        $this->totalAmountReceived = $totalAmountReceived;

        return $this;
    }

    /**
     * Get totalAmountReceived
     *
     * @return float
     */
    public function getTotalAmountReceived()
    {
        return $this->totalAmountReceived;
    }

    /**
     * Set deltaAmount
     *
     * @param float $deltaAmount
     *
     * @return Transaction
     */
    public function setDeltaAmount($deltaAmount)
    {
        $this->deltaAmount = $deltaAmount;

        return $this;
    }

    /**
     * Get deltaAmount
     *
     * @return float
     */
    public function getDeltaAmount()
    {
        return $this->deltaAmount;
    }

    /**
     * Set passerelle
     *
     * @param \AppBundle\Entity\Passerelle $passerelle
     *
     * @return Transactions
     */
    public function setPasserelle($passerelle)
    {
        $this->passerelle = $passerelle;

        return $this;
    }

    /**
     * Get passerelle
     *
     * @return \AppBundle\Entity\Passerelle
     */
    public function getPasserelle()
    {
        return $this->passerelle;
    }

     /**
     * Set abaccount
     *
     * @param \AppBundle\Entity\Abaccount $abaccount
     *
     * @return Transactions
     */
    public function setAbaccount($abaccount)
    {
        $this->abaccount = $abaccount;

        return $this;
    }

    /**
     * Get abaccount
     *
     * @return \AppBundle\Entity\Abaccount
     */
    public function getAbaccount()
    {
        return $this->abaccount;
    }
}

