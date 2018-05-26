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
/* @api */
define([], function () {
    'use strict';

    /**
     * @param {*} isValid
     * @param {*} isPotentiallyValid
     * @return {Object}
     */
    function resultWrapper(isValid, isPotentiallyValid) {
        return {
            isValid: isValid,
            isPotentiallyValid: isPotentiallyValid
        };
    }

    /**
     * CVV number validation.
     * Validate digit count fot CVV code.
     *
     * @param {*} value
     * @param {Number} maxLength
     * @return {Object}
     */
    return function (value, maxLength) {
        var DEFAULT_LENGTH = 3;

        maxLength = maxLength || DEFAULT_LENGTH;

        if (!/^\d*$/.test(value)) {
            return resultWrapper(false, false);
        }

        if (value.length === maxLength) {
            return resultWrapper(true, true);
        }

        if (value.length < maxLength) {
            return resultWrapper(false, true);
        }

        if (value.length > maxLength) {
            return resultWrapper(false, false);
        }
    };
});
