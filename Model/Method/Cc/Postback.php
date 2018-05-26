<?php
/**
 * Jefferson Porto
 *
 * Do not edit this file if you want to update this module for future new versions.
 *
 * @category  Az2009
 * @package   Az2009_Cielo
 *
 * @copyright Copyright (c) 2018 Jefferson Porto - (https://www.linkedin.com/in/jeffersonbatistaporto/)
 *
 * @author    Jefferson Porto <jefferson.b.porto@gmail.com>
 */
namespace Az2009\Cielo\Model\Method\Cc;

class Postback extends \Az2009\Cielo\Model\Method\AbstractMethod
{

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\DataObject $request,
        Response\Postback $response,
        Validate\Validate $validate,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Az2009\Cielo\Helper\Data $helper,
        \Magento\Framework\DataObject $update,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        parent::__construct(
            $context, $registry,
            $extensionFactory, $customAttributeFactory,
            $paymentData, $scopeConfig,
            $logger, $request,
            $response, $validate, $httpClientFactory,
            $helper, $update, $resource,
            $resourceCollection, $data
        );

        $this->_uri = $this->helper->getUriQuery();
    }

    public function process()
    {
        $paymentId = $this->getPaymentId();
        $this->setPath($paymentId, '');
        $this->request();
    }

    /**
     * Process response
     *
     * @param $response
     */
    protected function _processResponse()
    {
        if ($this->getPaymentUpdate() instanceof \Magento\Payment\Model\InfoInterface) {
            $this->getResponse()
                 ->setPayment($this->getPaymentUpdate());
        }

        $this->getResponse()
             ->process();
    }

    /**
     * Validate paymentId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getPaymentId()
    {
        $paymentId = $this->getData('payment_id');

        if (empty($paymentId)) {
            throw new \Exception(__('payment_id empty to send the postback'));
        }

        return $paymentId;
    }
}