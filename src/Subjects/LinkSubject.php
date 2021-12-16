<?php

/**
 * TechDivision\Import\Product\Link\Subjects\LinkSubject
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Subjects;

use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Product\Subjects\AbstractProductSubject;

/**
 * A subject implementation the process to import product links.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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
        $status = $registryProcessor->getAttribute(RegistryKeys::STATUS);

        // load the SKU => entity ID mapping
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
}
