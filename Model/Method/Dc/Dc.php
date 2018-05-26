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
namespace Az2009\Cielo\Model\Method\Dc;

class Dc extends \Az2009\Cielo\Model\Method\AbstractMethod
{

    /**
     * Code Payment
     */
    const CODE_PAYMENT = 'az2009_cielo_dc';

    /**
     * @var string
     */
    protected $_code = self::CODE_PAYMENT;

    /**
     * @var bool
     */
    protected $_canAuthorize = true;

    /**
     * @var bool
     */
    protected $_canCaptureOnce = false;

    /**
     * @var bool
     */
    protected $_canCapture = false;

    /**
     * @var bool
     */
    protected $_canFetchTransactionInfo = false;

    /**
     * @var bool
     */
    protected $_canRefund = true;

    /**
     * @var bool
     */
    protected $_canCapturePartial = false;

    /**
     * @var bool
     */
    protected $_canVoid = true;

    /**
     * @var bool
     */
    protected $_canReviewPayment = false;

    /**
     * @var bool
     */
    protected $_canCancelInvoice = true;

    /**
     * @var bool
     */
    protected $_canRefundInvoicePartial = false;

    /**
     * @var \Az2009\Cielo\Block\Form\Dc
     */
    protected $_infoBlockType = \Az2009\Cielo\Block\Info\Dc::class;

    /**
     * @var \Az2009\Cielo\Block\Form\Dc
     */
    protected $_formBlockType = \Az2009\Cielo\Block\Form\Dc::class;

    /**
     * @var \Az2009\Cielo\Model\Method\Dc\Postback
     */
    protected $_postback = \Az2009\Cielo\Model\Method\Dc\Postback::class;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        Request\Request $request,
        Response\Payment $response,
        Validate\Validate $validate,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Az2009\Cielo\Helper\Dc $helper,
        \Az2009\Cielo\Model\Method\Dc\Postback $update,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context, $registry, $extensionFactory,
            $customAttributeFactory, $paymentData, $scopeConfig, $logger,
            $request, $response, $validate, $httpClientFactory, $helper, $update,
            $resource, $resourceCollection, $data
        );
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isActive($storeId = null)
    {
        if ($this->_appState->getAreaCode()
            == \Magento\Framework\App\Area::AREA_ADMINHTML
        ) {
            return false;
        }

        return parent::isActive($storeId); // TODO: Change the autogenerated stub
    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     *
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        if ($this->_appState->getAreaCode()
            == \Magento\Framework\App\Area::AREA_ADMINHTML
        ) {
            return false;
        }

        return parent::isAvailable($quote); // TODO: Change the autogenerated stub
    }

    /**
     * @param string $country
     *
     * @return bool
     */
    public function canUseForCountry($country)
    {
        if ($country != self::CODE_COUNTRY_BR) {
            return false;
        }

        return true;
    }
}