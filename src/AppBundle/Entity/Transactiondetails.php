<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transactiondetails
 *
 * @ORM\Table(name="transactiondetails", indexes={@ORM\Index(name="transactionId_index", columns={"transaction_id"})})
 * @ORM\Entity
 */
class Transactiondetails
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="operation_date", type="date", length=255 ,nullable=false)
     */
    private $operationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="payement_method", type="string", length=255, nullable=false)
     */
    private $payementMethod;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount_received", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalAmountReceived;

    /**
     * @var string
     *
     * @ORM\Column(name="transaction_state", type="string", length=255, nullable=false)
     */
    private $transactionState;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn_sender", type="string", length=255, nullable=false)
     */
    private $msisdnSender;

    /**
     * @var string
     *
     * @ORM\Column(name="msisdn_receiver", type="string", length=255, nullable=false)
     */
    private $msisdnReceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255, nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255, nullable=false)
     */
    private $countryCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Transactions
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     * })
     */
    private $transaction;

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
     * Set operationDate
     *
     * @param \DateTime $operationDate
     *
     * @return TransactionDetails
     */
    public function setOperationDate($operationDate)
    {
        $this->operationDate = $operationDate;

        return $this;
    }

    /**
     * Get operationDate
     *
     * @return \DateTime
     */
    public function getOperationDate()
    {
        return $this->operationDate;
    }

    /**
     * Set payementMethod
     *
     * @param string $payementMethod
     *
     * @return TransactionDetails
     */
    public function setPayementMethod($payementMethod)
    {
        $this->payementMethod = $payementMethod;

        return $this;
    }

    /**
     * Get payementMethod
     *
     * @return string
     */
    public function getPayementMethod()
    {
        return $this->payementMethod;
    }

    /**
     * Set totalAmountReceived
     *
     * @param float $totalAmountReceived
     *
     * @return TransactionDetails
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
     * Set transactionState
     *
     * @param string $transactionState
     *
     * @return TransactionDetails
     */
    public function setTransactionState($transactionState)
    {
        $this->transactionState = $transactionState;

        return $this;
    }

    /**
     * Get transactionState
     *
     * @return string
     */
    public function getTransactionState()
    {
        return $this->transactionState;
    }

    /**
     * Set msisdnSender
     *
     * @param string $msisdnSender
     *
     * @return TransactionDetails
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
     * Set msisdnReceiver
     *
     * @param string $msisdnReceiver
     *
     * @return TransactionDetails
     */
    public function setMsisdnReceiver($msisdnReceiver)
    {
        $this->msisdnReceiver = $msisdnReceiver;

        return $this;
    }

    /**
     * Get msisdnReceiver
     *
     * @return string
     */
    public function getMsisdnReceiver()
    {
        return $this->msisdnReceiver;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return TransactionDetails
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
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return TransactionDetails
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
     * Set transaction
     *
     * @param \AppBundle\Entity\Transactions $transaction
     *
     * @return TransactionDetails
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \AppBundle\Entity\Transactions
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

}

