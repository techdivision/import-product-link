<?php

/**
 * TechDivision\Import\Product\Link\Utils\MemberNames
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
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class MemberNames extends \TechDivision\Import\Product\Utils\MemberNames
{

    /**
     * Name for the member 'link_id'.
     *
     * @var string
     */
    const LINK_ID = 'link_id';

    /**
     * Name for the member 'linked_product_id'.
     *
     * @var string
     */
    const LINKED_PRODUCT_ID = 'linked_product_id';

    /**
     * Name for the member 'product_link_attribute_id'.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_ID = 'product_link_attribute_id';

    /**
     * Name for the member 'value'.
     *
     * @var string
     */
    const VALUE = 'value';

    /**
     * Name for the member 'data_type'.
     *
     * @var string
     */
    const DATA_TYPE = 'data_type';
}
