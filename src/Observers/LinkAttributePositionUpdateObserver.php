<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkAttributePositionUpdateObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Observers;

use TechDivision\Import\Product\Link\Utils\MemberNames;

/**
 * Oberserver that provides functionality for the product link attribute position add/update operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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

        // load link/product link attribute ID
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
     * Initialize the product link attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attribute
     *
     * @return array The initialized product link attribute
     */
    protected function initializeProductLinkAttributeDecimal(array $attr)
    {

        // load link/product link attribute ID
        $linkId = $attr[MemberNames::LINK_ID];
        $productLinkAttributeId = $attr[MemberNames::PRODUCT_LINK_ATTRIBUTE_ID];

        // try to load the product link attribute decimal value with the passed product link attribute/link ID
        if ($entity = $this->loadProductLinkAttributeDecimal($productLinkAttributeId, $linkId)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Initialize the product link attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attribute
     *
     * @return array The initialized product link attribute
     */
    protected function initializeProductLinkAttributeVarchar(array $attr)
    {

        // load link/product link attribute ID
        $linkId = $attr[MemberNames::LINK_ID];
        $productLinkAttributeId = $attr[MemberNames::PRODUCT_LINK_ATTRIBUTE_ID];

        // try to load the product link attribute varchar value with the passed product link attribute/link ID
        if ($entity = $this->loadProductLinkAttributeVarchar($productLinkAttributeId, $linkId)) {
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
        return $this->getProductLinkProcessor()->loadProductLinkAttributeInt($productLinkAttributeId, $linkId);
    }

    /**
     * Return's the product link attribute decimal value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute decimal value
     */
    protected function loadProductLinkAttributeDecimal($productLinkAttributeId, $linkId)
    {
        return $this->getProductLinkProcessor()->loadProductLinkAttributeDecimal($productLinkAttributeId, $linkId);
    }

    /**
     * Return's the product link attribute varchar value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute varchar value
     */
    protected function loadProductLinkAttributeVarchar($productLinkAttributeId, $linkId)
    {
        return $this->getProductLinkProcessor()->loadProductLinkAttributeVarchar($productLinkAttributeId, $linkId);
    }
}
