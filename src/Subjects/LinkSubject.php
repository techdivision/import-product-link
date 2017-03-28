<?php

/**
 * TechDivision\Import\Product\Link\Subjects\LinkSubject
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

namespace TechDivision\Import\Product\Link\Subjects;

use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Subjects\AbstractProductSubject;
use TechDivision\Import\Product\Link\Exceptions\MapSkuToEntityIdException;
use TechDivision\Import\Product\Link\Exceptions\MapLinkTypeCodeToIdException;

/**
 * A subject implementation the process to import product links.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkSubject extends AbstractProductSubject
{

    /**
     * The temporary persisted last link ID.
     *
     * @var integer
     */
    protected $lastLinkId;

    /**
     * The available link types.
     *
     * @var array
     */
    protected $linkTypes = array();

    /**
     * The available link attributes.
     *
     * @var array
     */
    protected $linkAttributes = array();

    /**
     * The mapping for the SKUs to the created entity IDs.
     *
     * @var array
     */
    protected $skuEntityIdMapping = array();

    /**
     * Intializes the previously loaded global data for exactly one variants.
     *
     * @return void
     * @see \Importer\Csv\Actions\ProductImportAction::prepare()
     */
    public function setUp()
    {

        // invoke the parent method
        parent::setUp();

        // load the entity manager and the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // load the status of the actual import process
        $status = $registryProcessor->getAttribute($this->getSerial());

        // load the attribute set we've prepared intially
        $this->skuEntityIdMapping = $status[RegistryKeys::SKU_ENTITY_ID_MAPPING];

        // load the link types/attributes we've initialized before
        $this->linkTypes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::LINK_TYPES];
        $this->linkAttributes = $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::LINK_ATTRIBUTES];
    }

    /**
     * Temporary persist the last link ID.
     *
     * @param integer $lastLinkId The last link ID
     *
     * @return void
     */
    public function setLastLinkId($lastLinkId)
    {
        $this->lastLinkId = $lastLinkId;
    }

    /**
     * Load the temporary persisted the last link ID.
     *
     * @return integer The last link ID
     */
    public function getLastLinkId()
    {
        return $this->lastLinkId;
    }

    /**
     * Return the entity ID for the passed SKU.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \TechDivision\Import\Product\Link\Exceptions\MapSkuToEntityIdException Is thrown if the SKU is not mapped yet
     */
    public function mapSkuToEntityId($sku)
    {

        // query weather or not the SKU has been mapped
        if (isset($this->skuEntityIdMapping[$sku])) {
            return $this->skuEntityIdMapping[$sku];
        }

        // throw an exception if the SKU has not been mapped yet
        throw new MapSkuToEntityIdException(
            $this->appendExceptionSuffix(
                sprintf('Found not mapped entity ID for SKU %s', $sku)
            )
        );
    }

    /**
     * Return's the link type ID for the passed link type code.
     *
     * @param string $linkTypeCode The link type code to return the link type ID for
     *
     * @return integer The mapped link type ID
     * @throws \TechDivision\Import\Product\Link\Exceptions\MapLinkTypeCodeToIdException Is thrown if the link type code is not mapped yet
     */
    public function mapLinkTypeCodeToLinkTypeId($linkTypeCode)
    {

        // query weather or not the link type code has been mapped
        if (isset($this->linkTypes[$linkTypeCode])) {
            return $this->linkTypes[$linkTypeCode][MemberNames::LINK_TYPE_ID];
        }

        // throw an exception if the link type code has not been mapped yet
        throw new MapLinkTypeCodeToIdException(
            $this->appendExceptionSuffix(
                sprintf('Found not mapped link type code %s', $linkTypeCode)
            )
        );
    }

    /**
     * Return's the link attribute for the passed link type ID and attribute code.
     *
     * @param integer $linkTypeId    The link type
     * @param string  $attributeCode The attribute code
     *
     * @return array The link attribute
     */
    public function getProductLinkAttribute($linkTypeId, $attributeCode)
    {

        // try to load the link attribute with the passed link type ID and attribute code
        foreach ($this->linkAttributes as $linkAttribute) {
            if ($linkAttribute[MemberNames::LINK_TYPE_ID] === $linkTypeId &&
                $linkAttribute[MemberNames::PRODUCT_LINK_ATTRIBUTE_CODE] === $attributeCode
            ) {
                // return the matching link attribute
                return $linkAttribute;
            }
        }
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
    public function loadProductLink($productId, $linkedProductId, $linkTypeId)
    {
        return $this->getProductProcessor()->loadProductLink($productId, $linkedProductId, $linkTypeId);
    }

    /**
     * Return's the product link attribute integer value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute integer value
     */
    public function loadProductLinkAttributeInt($productLinkAttributeId, $linkId)
    {
        return $this->getProductProcessor()->loadProductLinkAttributeInt($productLinkAttributeId, $linkId);
    }

    /**
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLink($productLink)
    {
        return $this->getProductProcessor()->persistProductLink($productLink);
    }

    /**
     * Persist's the passed product link attribute integer data.
     *
     * @param array $productLinkAttributeInt The product link attribute integer data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttributeInt($productLinkAttributeInt)
    {
        $this->getProductProcessor()->persistProductLinkAttributeInt($productLinkAttributeInt);
    }
}
