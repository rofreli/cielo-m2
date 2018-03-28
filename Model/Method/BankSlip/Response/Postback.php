<?php

namespace Az2009\Cielo\Model\Method\BankSlip\Response;

class Postback extends \Az2009\Cielo\Model\Method\Cc\Response\Postback
{
    public function __construct(
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Authorize $authorize,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Unauthorized $unauthorized,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Capture $capture,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Pending $pending,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Cancel $cancel,
        \Magento\Sales\Model\Order $order,
        array $data = []
    ) {
        parent::__construct($authorize, $unauthorized, $capture, $pending, $cancel, $order, $data);
    }

    public function process()
    {
        $this->_getPaymentInstance();

        switch ($this->getStatus()) {
            case Payment::STATUS_AUTHORIZED:
            case Payment::STATUS_CAPTURED:
                $this->_capture
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->setPostback(true)
                    ->process();
                break;
            case Payment::STATUS_CANCELED_ABORTED:
            case Payment::STATUS_CANCELED_AFTER:
            case Payment::STATUS_CANCELED:
                $this->_cancel
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->setPostback(true)
                    ->process();
                break;
        }
    }
}