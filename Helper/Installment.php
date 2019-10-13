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
namespace Az2009\Cielo\Helper;

use Exception;
use Magento\Framework\App\Helper\Context;

class Installment extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Checkout\Model\Type\Onepage
     */
    protected $onepage;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Backend\Model\Session\Quote
     */
    protected $sessionQuote;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    public function __construct(
        Context $context,
        \Magento\Checkout\Model\Type\Onepage $onepage,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\State $state
    ) {
        parent::__construct($context);
        $this->onepage = $onepage;
        $this->checkoutSession = $checkoutSession;
        $this->sessionQuote = $sessionQuote;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getInstallmentsAvailable()
    {
        $quote = ($this->onepage !== false) ?
                        $this->onepage->getQuote() : $this->checkoutSession->getQuote();

        if ($this->state->getAreaCode() == \Magento\Framework\App\Area::AREA_ADMINHTML) {
            $quote = $this->sessionQuote->getQuote();
        }              

        $quote->setTotalsCollectedFlag(false)->collectTotals();
        $amount = (float) $quote->getGrandTotal();
        
        return $this->BuildAvailableInstallments($amount);
    }

    private function BuildAvailableInstallments(float $amount){
        $installments = $this->getInstallmentsFromConfig();
        $result = [];
        foreach ($installments as $installment) {

            if ($installment['installment_frequency'] != '' && $installment['installment_boundary'] != '') {              
                $frequency = $installment['installment_frequency'];
                $installmetnAmount = $amount / $installment['installment_frequency']; 

                if ($installmetnAmount >= $installment['installment_boundary']) {

                    $result[(string)$frequency] = $frequency . "x " . $this->formatPrice($installmetnAmount + 3, false);
                }
            } 
        }

        return $result;
    }

    private function getInstallmentsFromConfig(){
        $value = $this->scopeConfig->getValue(
            'payment/az2009_cielo/installments',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        
    
    $value = json_decode($value, true);
    
    return $value;

    }

    /**
     * @param $price
     * @param bool $includeContainer
     *
     * @return float
     */
    public function formatPrice($price, $includeContainer = true)
    {
        return $this->priceCurrency->format(
            $price,
            $includeContainer,
            \Magento\Framework\Pricing\PriceCurrencyInterface::DEFAULT_PRECISION,
            $this->storeManager->getStore()
        );
    }

}