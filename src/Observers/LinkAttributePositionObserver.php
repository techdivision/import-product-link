<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkAttributePositionObserver
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

use TechDivision\Import\Product\Link\Utils\ColumnKeys;
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;
use TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface;

/**
 * Oberserver that provides functionality for the product link attribute position replace operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkAttributePositionObserver extends AbstractProductImportObserver
{

    /**
     * The link attribute that has to be handled by this observer.
     *
     * @var string
     */
    const ATTRIBUTE_CODE = 'position';

    /**
     * The product link attribute ID to persist the the position attribute for.
     *
     * @var integer
     */
    protected $productLinktAttributeId;

    /**
     * The product link processor instance.
     *
     * @var \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface
     */
    protected $productLinkProcessor;

    /**
     * Initialize the observer with the passed product link processor instance.
     *
     * @param \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface $productLinkProcessor The product link processor instance
     */
    public function __construct(ProductLinkProcessorInterface $productLinkProcessor)
    {
        $this->productLinkProcessor= $productLinkProcessor;
    }

    /**
     * Return's the product link processor instance.
     *
     * @return \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface The product link processor instance
     */
    protected function getProductLinkProcessor()
    {
        return $this->productLinkProcessor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // initialize the attribute code
        $attributeCode = LinkAttributePositionObserver::ATTRIBUTE_CODE;

        try {
            // extract the link type code from the row
            $linkTypeId = $this->mapLinkTypeCodeToLinkTypeId($this->getValue(ColumnKeys::LINK_TYPE_CODE));
        } catch (\Exception $e) {
            // query whether or not, debug mode is enabled
            if ($this->isDebugMode()) {
                // log a warning and return immediately
                $this->getSystemLogger()->warning($e->getMessage());
                return;
            }

            // if we're NOT in debug mode, re-throw the exception
            throw $e;
        }

        // try to load the product link attribute
        if ($productLinkAttribute = $this->getProductLinkAttribute($linkTypeId, $attributeCode)) {
            $this->setProductLinkAttributeId($productLinkAttribute[MemberNames::PRODUCT_LINK_ATTRIBUTE_ID]);
        } else {
            return;
        }

        // prepare, initialize and persist the product link attribute int entity
        $productLink = $this->initializeProductLinkAttributeInt($this->prepareAttributes());
        $this->persistProductLinkAttributeInt($productLink);
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // load the ID of the last link
        $linkId = $this->getLastLinkId();

        // load the product link attribute ID
        $productLinkAttributeId = $this->getProductLinkAttributeId();

        // load the position value
        $value = $this->getValue(ColumnKeys::LINK_POSITION);

        // initialize and return the entity
        return $this->initializeEntity(
            array(
                MemberNames::PRODUCT_LINK_ATTRIBUTE_ID => $productLinkAttributeId,
                MemberNames::LINK_ID                   => $linkId,
                MemberNames::VALUE                     => $value
            )
        );
    }

    /**
     * Temporary persist the product link attribute ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID
     *
     * @return void
     */
    protected function setProductLinkAttributeId($productLinkAttributeId)
    {
        $this->productLinktAttributeId = $productLinkAttributeId;
    }

    /**
     * Return's the temporary persisted product link attribute ID.
     *
     * @return integer The product link attribute ID
     */
    protected function getProductLinkAttributeId()
    {
        return $this->productLinktAttributeId;
    }

    /**
     * Return's the link attribute for the passed link type ID and attribute code.
     *
     * @param integer $linkTypeId    The link type
     * @param string  $attributeCode The attribute code
     *
     * @return array The link attribute
     */
    protected function getProductLinkAttribute($linkTypeId, $attributeCode)
    {
        return $this->getSubject()->getProductLinkAttribute($linkTypeId, $attributeCode);
    }

    /**
     * Initialize the product link attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attribute
     *
     * @return array The initialized product link attribute
     */
    protected function initializeProductLinkAttributeInt(array $attr)
    {
        return $attr;
    }

    /**
     * Load the temporary persisted the last link ID.
     *
     * @return integer The last link ID
     */
    protected function getLastLinkId()
    {
        return $this->getSubject()->getLastLinkId();
    }

    /**
     * Return the link type ID for the passed link type code.
     *
     * @param string $linkTypeCode The link type code to return the link type ID for
     *
     * @return integer The mapped link type ID
     * @throws \Exception Is thrown if the link type code is not mapped yet
     */
    protected function mapLinkTypeCodeToLinkTypeId($linkTypeCode)
    {
        return $this->getSubject()->mapLinkTypeCodeToLinkTypeId($linkTypeCode);
    }

    /**
     * Persist's the passed product link attribute int data and return's the ID.
     *
     * @param array $productLinkAttributeInt The product link attribute int data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistProductLinkAttributeInt($productLinkAttributeInt)
    {
        $this->getProductLinkProcessor()->persistProductLinkAttributeInt($productLinkAttributeInt);
    }
}
