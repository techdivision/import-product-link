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
use TechDivision\Import\Product\Subjects\AbstractProductSubject;
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface;

/**
 * A SLSB that handles the process to import product links.
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
     * The available link types.
     *
     * @var array
     */
    protected $linkTypes = array();

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
    }

    /**
     * Return the entity ID for the passed SKU.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \Exception Is thrown if the SKU is not mapped yet
     */
    public function mapSkuToEntityId($sku)
    {

        // query weather or not the SKU has been mapped
        if (isset($this->skuEntityIdMapping[$sku])) {
            return $this->skuEntityIdMapping[$sku];
        }

        // throw an exception if the SKU has not been mapped yet
        throw new \Exception(sprintf('Found not mapped SKU %s', $sku));
    }

    /**
     * Return the link type ID for the passed link type code.
     *
     * @param string $linkTypeCode The link type code to return the link type ID for
     *
     * @return integer The mapped link type ID
     * @throws \Exception Is thrown if the link type code is not mapped yet
     */
    public function mapLinkTypeCodeToLinkTypeId($linkTypeCode)
    {

        // query weather or not the link type code has been mapped
        if (isset($this->linkTypes[$linkTypeCode])) {
            return $this->linkTypes[$linkTypeCode][MemberNames::LINK_TYPE_ID];
        }

        // throw an exception if the link type code has not been mapped yet
        throw new \Exception(sprintf('Found not mapped link type code %s', $linkTypeCode));
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
     * Persist's the passed product link attribute data and return's the ID.
     *
     * @param array $productLinkAttribute The product link attribute data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttribute($productLinkAttribute)
    {
        return $this->getProductProcessor()->persistProductLinkAttribute($productLinkAttribute);
    }

    /**
     * Persist's the passed product link attribute decimal data.
     *
     * @param array $productLinkAttributeDecimal The product link attribute decimal data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeDecimal($productLinkAttributeDecimal)
    {
        $this->getProductProcessor()->persistProductLinkAttributeDecimal($productLinkAttributeDecimal);
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

    /**
     * Persist's the passed product link attribute varchar data.
     *
     * @param array $productLinkAttributeVarchar The product link attribute varchar data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttributeVarchar($productLinkAttributeVarchar)
    {
        $this->getProductProcessor()->persistProductLinkAttributeVarchar($productLinkAttributeVarchar);
    }
}
