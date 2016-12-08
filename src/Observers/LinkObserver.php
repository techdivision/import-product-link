<?php

/**
 * TechDivision\Import\Product\Link\Observers\LinkObserver
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

use TechDivision\Import\Product\Observers\AbstractProductImportObserver;
use TechDivision\Import\Product\Link\Utils\ColumnKeys;

/**
 * A SLSB that handles the process to import product links.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class LinkObserver extends AbstractProductImportObserver
{

    /**
     * {@inheritDoc}
     * @see \Importer\Csv\Actions\Listeners\Row\ListenerInterface::handle()
     */
    public function handle(array $row)
    {

        // load the header information
        $headers = $this->getHeaders();

        // extract the parent/child ID as well as the link type code from the row
        $parentSku = $row[$headers[ColumnKeys::LINK_PARENT_SKU]];
        $childSku = $row[$headers[ColumnKeys::LINK_CHILD_SKU]];
        $linkTypeCode = $row[$headers[ColumnKeys::LINK_TYPE_CODE]];

        // load parent/child IDs and link type ID
        $parentId = $this->mapSkuToEntityId($parentSku);
        $childId = $this->mapSkuToEntityId($childSku);
        $linkTypeId = $this->mapLinkTypeCodeToLinkTypeId($linkTypeCode);

        // persist the product link
        $this->persistProductLink(array($parentId, $childId, $linkTypeId));

        // returns the row
        return $row;
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
        return $this->getSubject()->persistProductLink($productLink);
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
        return $this->getSubject()->mapSkuToEntityId($sku);
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
        return $this->getSubject()->mapLinkTypeCodeToLinkTypeId($linkTypeCode);
    }
}
