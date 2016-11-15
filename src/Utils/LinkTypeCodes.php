<?php

/**
 * TechDivision\Import\Product\Link\Utils\LinkTypeCodes
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/csv-import
 * @link      http://www.appserver.io
 */

namespace TechDivision\Import\Product\Link\Utils;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/csv-import
 * @link      http://www.appserver.io
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
