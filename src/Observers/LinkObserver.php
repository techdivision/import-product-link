<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkObserver
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
use TechDivision\Import\Utils\RegistryKeys;

/**
 * Oberserver that provides functionality for the product link replace operation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkObserver extends AbstractProductImportObserver
{

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

        // prepare the product link entity
        if ($attr = $this->prepareAttributes()) {
            // initialize the product link entity
            $productLink = $this->initializeProductLink($attr);

            // persist the product link entity and store the link ID
            $this->setLastLinkId($this->persistProductLink($productLink));
        }
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        try {
            // extract the link type code from the row
            $linkTypeId = $this->mapLinkTypeCodeToLinkTypeId($this->getValue(ColumnKeys::LINK_TYPE_CODE));
            // initialize the column name
            $columnName = ColumnKeys::LINK_PARENT_SKU;
            // extract the parent + child ID from the row
            $parentId = $this->mapSku($this->getValue($columnName));
            $childId = $this->mapSkuToEntityId($this->getValue($columnName = ColumnKeys::LINK_CHILD_SKU));
        } catch (\Exception $e) {
            // query whether or not, debug mode is enabled
            if (!$this->isStrictMode()) {
                // stop processing the row
                $this->skipRow();
                // log a warning and return immediately
                $this->getSystemLogger()->warning($e->getMessage());
                $this->mergeStatus(
                    array(
                        RegistryKeys::NO_STRICT_VALIDATIONS => array(
                            basename($this->getFilename()) => array(
                                $this->getLineNumber() => array($columnName =>  $e->getMessage()
                                )
                            )
                        )
                    )
                );
                return [];
            }
            // if we're NOT in debug mode, re-throw the exception
            throw $columnName ? $this->wrapException(array($columnName), $e) : $e;
        }

        // initialize and return the entity
        return $this->initializeEntity(
            array(
                MemberNames::PRODUCT_ID        => $parentId,
                MemberNames::LINKED_PRODUCT_ID => $childId,
                MemberNames::LINK_TYPE_ID      => $linkTypeId
            )
        );
    }

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
        return $this->getProductLinkProcessor()->loadProductLink($productId, $linkedProductId, $linkTypeId);
    }

    /**
     * Temporary persist the last link ID.
     *
     * @param integer $lastLinkId The last link ID
     *
     * @return void
     */
    protected function setLastLinkId($lastLinkId)
    {
        $this->getSubject()->setLastLinkId($lastLinkId);
    }

    /**
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistProductLink($productLink)
    {
        return $this->getProductLinkProcessor()->persistProductLink($productLink);
    }

    /**
     * Return the entity ID for the passed SKU.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \TechDivision\Import\Product\Exceptions\MapSkuToEntityIdException Is thrown if the SKU is not mapped yet
     */
    protected function mapSkuToEntityId($sku)
    {
        return $this->getSubject()->mapSkuToEntityId($sku);
    }

    /**
     * Return the entity ID for the passed SKU.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \TechDivision\Import\Product\Exceptions\MapSkuToEntityIdException Is thrown if the SKU is not mapped yet
     */
    protected function mapSku($sku)
    {
        return $this->getSubject()->mapSkuToEntityId($sku);
    }

    /**
     * Return the link type ID for the passed link type code.
     *
     * @param string $linkTypeCode The link type code to return the link type ID for
     *
     * @return integer The mapped link type ID
     * @throws \TechDivision\Import\Product\Exceptions\MapLinkTypeCodeToIdException Is thrown if the link type code is not mapped yet
     */
    protected function mapLinkTypeCodeToLinkTypeId($linkTypeCode)
    {
        return $this->getSubject()->mapLinkTypeCodeToLinkTypeId($linkTypeCode);
    }

    /**
     * Queries whether or not debug mode is enabled or not, default is TRUE.
     *
     * @return boolean TRUE if debug mode is enabled, else FALSE
     */
    protected function isDebugMode()
    {
        return $this->getSubject()->isDebugMode();
    }
    
    /**
     * Queries whether or not strict mode is enabled or not, default is True.
     * Backward compatibility
     * debug = true strict = true -> isStrict == FALSE
     * debug = true strict = false -> isStrict == FALSE
     * debug = false strict = true -> isStrict == TRUE
     * debug = false strict = false -> isStrict == FALSE
     *
     * @return boolean TRUE if strict mode is enabled and debug mode disable, else FALSE
     */
    public function isStrictMode()
    {
        return $this->getSubject()->isStrictMode();
    }
}
