<?php

namespace Az2009\Cielo\Model\Method\Cc\Transaction;

class Authorize extends \Az2009\Cielo\Model\Method\Transaction
{

    /**
     * @var \Az2009\Cielo\Helper\Data
     */
    protected $helper;

    public function __construct(\Az2009\Cielo\Helper\Data $helper, array $data = [])
    {
        $this->helper = $helper;
        parent::__construct($data);
    }

    /**
     * process the authorization
     * @return $this
     */
    public function process()
    {
        $payment = $this->getPayment();
        $bodyArray = $this->getBody(\Zend\Json\Json::TYPE_ARRAY);

        if (!property_exists($this->getBody(), 'Payment')) {
            throw new \Az2009\Cielo\Exception\Cc(_('Payment not authorized'));
        }

        $paymentId = $this->getBody()->Payment->PaymentId;

        if (empty($paymentId)) {
            throw new \Az2009\Cielo\Exception\Cc(_('Payment not authorized'));
        }

        if (!$payment->getTransactionId() && !empty($paymentId)) {
            $payment->setTransactionId($paymentId)
                    ->setLastTransId($paymentId);
            $payment->setAdditionalInformation(
                'transaction_authorization',
                $paymentId
            );
        }

        $this->prepareBodyTransaction($bodyArray);

        $payment->setTransactionAdditionalInfo(
            \Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS,
            $this->getTransactionData()
        );

        $payment->setIsTransactionClosed(false);

        $payment->getOrder()
                ->setStatus($this->helper->getStatusPay());

        return $this;
    }

}