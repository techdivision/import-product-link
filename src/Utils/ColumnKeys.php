<?php

/**
 * TechDivision\Import\Product\Link\Utils\ColumnKeys
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
class ColumnKeys extends \TechDivision\Import\Product\Utils\ColumnKeys
{

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
     * Name for the column 'link_type_attribute_code'.
     *
     * @var string
     */
    const LINK_TYPE_ATTRIBUTE_CODE = 'link_type_attribute_code';

    /**
     * Name for the column 'link_type_attribute_value'.
     *
     * @var string
     */
    const LINK_TYPE_ATTRIBUTE_VALUE = 'link_type_attribute_value';

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

    /**
     * Name for the column 'related_position'.
     *
     * @var string
     */
    const RELATED_POSITION = 'related_position';

    /**
     * Name for the column 'upsell_position'.
     *
     * @var string
     */
    const UPSELL_POSITION = 'upsell_position';

    /**
     * Name for the column 'crosssell_position'.
     *
     * @var string
     */
    const CROSSSELL_POSITION = 'crosssell_position';
}
