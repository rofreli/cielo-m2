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
namespace Az2009\Cielo\Model\Source;

class CountryCodes extends \Magento\Directory\Model\Config\Source\Country
{
    /**
     * Get code alpha3 country by code alpha2
     *
     * @param $alpha2
     *
     * @return string
     */
    public function getCountryCodeAlpha3($alpha2)
    {
        $alpha2 = strtoupper($alpha2);
        $item = $this->_countryCollection
                     ->addCountryCodeFilter($alpha2, 'iso2')
                     ->loadData()
                     ->getFirstItem();

        $iso3Code = $item->getData('iso3_code');
        if (empty($iso3Code)) {
            throw new \Az2009\Cielo\Exception\Cc(__('Code ISO3 of country not found'));
        }

        return $iso3Code;
    }

}
