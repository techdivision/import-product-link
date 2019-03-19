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
use TechDivision\Import\Product\Link\Exceptions\MapSkuToEntityIdException;

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
     * The mapping for the SKUs to the created entity IDs.
     *
     * @var array
     */
    protected $skuEntityIdMapping = array();

    /**
     * Intializes the previously loaded global data for exactly one variants.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // invoke the parent method
        parent::setUp($serial);

        // load the entity manager and the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // load the status of the actual import process
        $status = $registryProcessor->getAttribute($serial);

        // load the attribute set we've prepared intially
        $this->skuEntityIdMapping = $status[RegistryKeys::SKU_ENTITY_ID_MAPPING];
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
}
