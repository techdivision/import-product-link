<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkAttributePositionObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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
 * @license   https://opensource.org/licenses/MIT
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

        // process the link type attributes
        $productLinkAttribute = $this->getProductLinkAttributeByLinkTypeCodeAndAttributeCode($this->getValue(ColumnKeys::LINK_TYPE_CODE), $this->getValue(ColumnKeys::LINK_TYPE_ATTRIBUTE_CODE));

        // try to load the product link attribute
        $this->setProductLinkAttributeId($productLinkAttribute[MemberNames::PRODUCT_LINK_ATTRIBUTE_ID]);

        // load the link attribute data type
        $dataType = $productLinkAttribute[MemberNames::DATA_TYPE];

        // concatenate the initialize/persist method names
        $intializeMethod = sprintf('initializeProductLinkAttribute%s', $dataType);
        $persistMethod = sprintf('persistProductLinkAttribute%s', $dataType);

        // prepare, initialize and persist the product link attribute int entity
        $this->$persistMethod($this->$intializeMethod($this->prepareAttributes()));
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
        $value = $this->getValue(ColumnKeys::LINK_TYPE_ATTRIBUTE_VALUE);

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
     * Return's the link attribute for the passed link type and attribute code.
     *
     * @param string $linkTypeCode  The link type code
     * @param string $attributeCode The attribute code
     *
     * @return array The link attribute
     */
    protected function getProductLinkAttributeByLinkTypeCodeAndAttributeCode($linkTypeCode, $attributeCode)
    {
        return $this->getSubject()->getProductLinkAttributeByLinkTypeCodeAndAttributeCode($linkTypeCode, $attributeCode);
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
     * Initialize the product link attribute with the passed attributes and returns an instance.
     *
     * @param array $attr The product link attribute
     *
     * @return array The initialized product link attribute
     */
    protected function initializeProductLinkAttributeDecimal(array $attr)
    {
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
     * Persists the passed product link attribute int data and return's the ID.
     *
     * @param array $productLinkAttributeInt The product link attribute int data to persist
     *
     * @return void
     */
    protected function persistProductLinkAttributeInt($productLinkAttributeInt)
    {
        $this->getProductLinkProcessor()->persistProductLinkAttributeInt($productLinkAttributeInt);
    }

    /**
     * Persists the passed product link attribute decimal data and return's the ID.
     *
     * @param array $productLinkAttributeDecimal The product link attribute decimal data to persist
     *
     * @return void
     */
    protected function persistProductLinkAttributeDecimal($productLinkAttributeDecimal)
    {
        $this->getProductLinkProcessor()->persistProductLinkAttributeDecimal($productLinkAttributeDecimal);
    }

    /**
     * Persists the passed product link attribute varchar data and return's the ID.
     *
     * @param array $productLinkAttributeVarchar The product link attribute varchar data to persist
     *
     * @return void
     */
    protected function persistProductLinkAttributeVarchar($productLinkAttributeVarchar)
    {
        $this->getProductLinkProcessor()->persistProductLinkAttributeVarchar($productLinkAttributeVarchar);
    }
}
