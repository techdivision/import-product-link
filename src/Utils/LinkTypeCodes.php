<?php

/**
 * TechDivision\Import\Product\Link\Utils\LinkTypeCodes
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Utils;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkTypeCodes
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * The link type code for related products.
     *
     * @var string
     */
    const RELATION = 'relation';

    /**
     * The link type code for super products.
     *
     * @var string
     */
    const SUPER = 'super';

    /**
     * The link type code for up sell products.
     *
     * @var string
     */
    const UP_SELL = 'up_sell';

    /**
     * The link type code for cross sell products.
     *
     * @var string
     */
    const CROSS_SELL = 'cross_sell';
}
