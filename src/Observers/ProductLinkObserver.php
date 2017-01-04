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
    protected $linkTypeCodeToColumnsMapping = array(
         LinkTypeCodes::RELATION   => array(ColumnKeys::RELATED_SKUS, ColumnKeys::RELATED_POSITION),
         LinkTypeCodes::UP_SELL    => array(ColumnKeys::UPSELL_SKUS, ColumnKeys::UPSELL_POSITION),
         LinkTypeCodes::CROSS_SELL => array(ColumnKeys::CROSSSELL_SKUS, ColumnKeys::CROSSSELL_POSITION)
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

        // initialize the row
        $this->setRow($row);

        // process the functionality and return the row
        $this->process();

        // return the processed row
        return $this->getRow();
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // initialize the array for the links
        $artefacts = array();

        // prepare the links for the found link types and merge the found artefacts
        foreach ($this->getLinkTypeCodeToColumnsMapping() as $linkTypeCode => $columns) {
            $artefacts = array_merge($artefacts, $this->prepareArtefacts($linkTypeCode, $columns));
        }

        // append the links to the subject
        $this->addArtefacts($artefacts);
    }

    /**
     * Prepare's and return's the artefacts for the passed link type.
     *
     * @param string $linkTypeCode The link type code to prepare the artefacts for
     * @param array  $columns      The column names that contains the data (SKU + position)
     *
     * @return array The link artefacts assembled from the passed row
     */
    protected function prepareArtefacts($linkTypeCode, array $columns)
    {

        // initialize the array for the product media
        $artefacts = array();

        // extract the column names
        list ($columnNameSku, $columnNamePosition) = $columns;

        // query whether or not, we've up sell products
        if ($links = $this->getValue($columnNameSku, null, array($this, 'explode'))) {
            // load the parent SKU from the row
            $parentSku = $this->getValue(ColumnKeys::SKU);
            // extract the link positions, if available
            $linkPositions = $this->getValue($columnNamePosition, array(), array($this, 'explode'));

            // load the SKUs of the related products
            foreach ($links as $key => $childSku) {
                // prepare the link position
                $linkPosition = $key + 1;
                if (isset($linkPositions[$key]) && !empty($linkPositions[$key])) {
                    $linkPosition = $linkPositions[$key];
                }

                // prepare and append the relation to the artefacts
                $artefacts[] = array(
                    ColumnKeys::LINK_PARENT_SKU  => $parentSku,
                    ColumnKeys::LINK_CHILD_SKU   => $childSku,
                    ColumnKeys::LINK_TYPE_CODE   => $linkTypeCode,
                    ColumnKeys::LINK_POSITION    => $linkPosition
                );
            }
        }

        // return the artefacts
        return $artefacts;
    }

    /**
     * Return's the link type code => colums mapping.
     *
     * @return array The mapping with the link type codes => colums
     */
    protected function getLinkTypeCodeToColumnsMapping()
    {
        return $this->linkTypeCodeToColumnsMapping;
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
    protected function addArtefacts(array $artefacts)
    {
        $this->getSubject()->addArtefacts(ProductLinkObserver::ARTEFACT_TYPE, $artefacts);
    }
}
