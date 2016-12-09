<?php

/**
 * TechDivision\Import\Product\Link\Observers\ProductLinkObserver
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
use TechDivision\Import\Product\Link\Utils\LinkTypeCodes;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * A SLSB that handles the process to import product links.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductLinkObserver extends AbstractProductImportObserver
{

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'links';

    /**
     * The mapping with the link type codes => column names.
     *
     * @var array
     */
    protected $linkTypeCodeToColumnNameMapping = array(
         LinkTypeCodes::RELATION   => ColumnKeys::RELATED_SKUS,
         LinkTypeCodes::UP_SELL    => ColumnKeys::UPSELL_SKUS,
         LinkTypeCodes::CROSS_SELL => ColumnKeys::CROSSSELL_SKUS
    );

    /**
     * Will be invoked by the action on the events the listener has been registered for.
     *
     * @param array $row The row to handle
     *
     * @return array The modified row
     * @see \TechDivision\Import\Product\Observers\ImportObserverInterface::handle()
     */
    public function handle(array $row)
    {

        // initialize the array for the links
        $artefacts = array();

        // prepare the links for the found link types and merge the found artefacts
        foreach ($this->getLinkTypeCodeToColumnNameMapping() as $linkTypeCode => $columnName) {
            $artefacts = array_merge($artefacts, $this->prepareArtefacts($row, $linkTypeCode, $columnName));
        }

        // append the links to the subject
        $this->addArtefacts($artefacts);

        // returns the row
        return $row;
    }

    /**
     * Prepare's and return's the artefacts for the passed link type.
     *
     * @param array  $row          The row with the artefact data to prepare
     * @param string $linkTypeCode The link type code to prepare the artefacts for
     * @param string $columnName   The column name that contains the data
     *
     * @return array The link artefacts assembled from the passed row
     */
    public function prepareArtefacts(array $row, $linkTypeCode, $columnName)
    {

        // load the header information
        $headers = $this->getHeaders();

        // initialize the array for the product media
        $artefacts = array();

        // query whether or not, we've up sell products
        if (!empty($row[$headers[$columnName]])) {
            // load the parent SKU from the row
            $parentSku = $row[$headers[ColumnKeys::SKU]];

            // load the SKUs of the related products
            foreach (explode(',', $row[$headers[$columnName]]) as $childSku) {
                // prepare and append the relation to the artefacts
                $artefacts[] = array(
                    ColumnKeys::LINK_PARENT_SKU  => $parentSku,
                    ColumnKeys::LINK_CHILD_SKU   => $childSku,
                    ColumnKeys::LINK_TYPE_CODE   => $linkTypeCode,
                );
            }
        }

        // return the artefacts
        return $artefacts;
    }

    /**
     * Return's the link type code => column name mapping.
     *
     * @return array The mapping with the link type codes => column names
     */
    public function getLinkTypeCodeToColumnNameMapping()
    {
        return $this->linkTypeCodeToColumnNameMapping;
    }

    /**
     * Add the passed product type artefacts to the product with the
     * last entity ID.
     *
     * @param array $artefacts The product type artefacts
     *
     * @return void
     * @uses \TechDivision\Import\Product\Media\Subjects\MediaSubject::getLastEntityId()
     */
    public function addArtefacts(array $artefacts)
    {
        $this->getSubject()->addArtefacts(ProductLinkObserver::ARTEFACT_TYPE, $artefacts);
    }
}
