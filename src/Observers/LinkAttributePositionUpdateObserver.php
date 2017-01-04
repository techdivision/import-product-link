<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkAttributePositionUpdateObserver
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
 * Oberserver that provides functionality for the product link attribute position add/update operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkAttributePositionUpdateObserver extends LinkAttributePositionObserver
{

    /**
     * Initialize the product link attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attribute
     *
     * @return array The initialized product link attribute
     */
    protected function initializeProductLinkAttributeInt(array $attr)
    {

        // load value/link/product link attribute ID
        $value = $attr[MemberNames::VALUE];
        $linkId = $attr[MemberNames::LINK_ID];
        $productLinkAttributeId = $attr[MemberNames::PRODUCT_LINK_ATTRIBUTE_ID];

        // try to load the product link attribute integer value with the passed product link attribute/link ID
        if ($entity = $this->loadProductLinkAttributeInt($productLinkAttributeId, $linkId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Return's the product link attribute integer value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute integer value
     */
    protected function loadProductLinkAttributeInt($productLinkAttributeId, $linkId)
    {
        return $this->getSubject()->loadProductLinkAttributeInt($productLinkAttributeId, $linkId);
    }
}
