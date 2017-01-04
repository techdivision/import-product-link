<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkUpdateObserver
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

namespace TechDivision\Import\Product\Link\Observers;

use TechDivision\Import\Product\Link\Utils\MemberNames;

/**
 * Oberserver that provides functionality for the product link add/update operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkUpdateObserver extends LinkObserver
{

    /**
     * Initialize the product link with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attributes
     *
     * @return array The initialized product link
     */
    protected function initializeProductLink(array $attr)
    {

        // load the product/linked product/link type ID
        $productId = $attr[MemberNames::PRODUCT_ID];
        $linkTypeId = $attr[MemberNames::LINK_TYPE_ID];
        $linkedProductId = $attr[MemberNames::LINKED_PRODUCT_ID];

        // try to load the link with the passed product/linked product/link type ID
        if ($entity = $this->loadProductLink($productId, $linkedProductId, $linkTypeId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Load's the link with the passed product/linked product/link type ID.
     *
     * @param integer $productId       The product ID of the link to load
     * @param integer $linkedProductId The linked product ID of the link to load
     * @param integer $linkTypeId      The link type ID of the product to load
     *
     * @return array The link
     */
    protected function loadProductLink($productId, $linkedProductId, $linkTypeId)
    {
        return $this->getSubject()->loadProductLink($productId, $linkedProductId, $linkTypeId);
    }
}
