<?php

/**
 * TechDivision\Import\Product\Link\Utils\ColumnKeys
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

use TechDivision\Import\Product\Utils\ColumnKeys as FallbackColumnKeys;

/**
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/wagnert/csv-import
 * @link      http://www.appserver.io
 */
class ColumnKeys extends FallbackColumnKeys
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
     * Name for the column 'link_parent_sku'.
     *
     * @var string
     */
    const LINK_PARENT_SKU = 'link_parent_sku';

    /**
     * Name for the column 'link_child_sku'.
     *
     * @var string
     */
    const LINK_CHILD_SKU = 'link_child_sku';

    /**
     * Name for the column 'link_type_code'.
     *
     * @var string
     */
    const LINK_TYPE_CODE = 'link_type_code';

    /**
     * Name for the column 'related_skus'.
     *
     * @var string
     */
    const RELATED_SKUS = 'related_skus';

    /**
     * Name for the column 'upsell_skus'.
     *
     * @var string
     */
    const UPSELL_SKUS = 'upsell_skus';

    /**
     * Name for the column 'crosssell_skus'.
     *
     * @var string
     */
    const CROSSSELL_SKUS = 'crosssell_skus';
}
