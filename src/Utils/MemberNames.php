<?php

/**
 * TechDivision\Import\Product\Link\Utils\MemberNames
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Utils;

/**
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * Name for the member 'link_type_id'.
     *
     * @var string
     */
    const LINK_TYPE_ID = 'link_type_id';

    /**
     * Name for the member 'product_link_attribute_id'.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_ID = 'product_link_attribute_id';

    /**
     * Name for the member 'product_link_attribute_code'.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_CODE = 'product_link_attribute_code';

    /**
     * Name for the member 'value'.
     *
     * @var string
     */
    const VALUE = 'value';
}
