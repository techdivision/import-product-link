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
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Prepares the artefacts for the generic link type import.
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
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // initialize the array for the links
        $artefacts = array();

        // prepare the links for the found link types and merge the found artefacts
        foreach ($this->getLinkTypeMappings() as $linkTypeCode => $columns) {
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
                $artefacts[] = $this->newArtefact(
                    array(
                        ColumnKeys::LINK_PARENT_SKU => $parentSku,
                        ColumnKeys::LINK_CHILD_SKU  => $childSku,
                        ColumnKeys::LINK_TYPE_CODE  => $linkTypeCode,
                        ColumnKeys::LINK_POSITION   => $linkPosition
                    ),
                    array(
                        ColumnKeys::LINK_PARENT_SKU => ColumnKeys::SKU,
                        ColumnKeys::LINK_CHILD_SKU  => $columnNameSku,
                        ColumnKeys::LINK_POSITION   => $columnNamePosition
                    )
                );
            }
        }

        // return the artefacts
        return $artefacts;
    }

    /**
     * Return's the available link types.
     *
     * @return array The link types
     */
    protected function getLinkTypes()
    {
        return $this->getSubject()->getLinkTypes();
    }

    /**
     * Return's the link type code => colums mapping.
     *
     * @return array The mapping with the link type codes => colums
     */
    protected function getLinkTypeMappings()
    {

        // initialize the array with link type mappings
        $linkTypeMappings = array();

        // prepare the link type mappings
        foreach ($this->getLinkTypes() as $linkType) {
            $linkTypeMappings[$linkType[MemberNames::CODE]] = array(
                sprintf('%s_skus', $linkType[MemberNames::CODE]),
                sprintf('%s_position', $linkType[MemberNames::CODE]),
            );
        }

        // return the link type mappings
        return $linkTypeMappings;
    }

    /**
     * Create's and return's a new empty artefact entity.
     *
     * @param array $columns             The array with the column data
     * @param array $originalColumnNames The array with a mapping from the old to the new column names
     *
     * @return array The new artefact entity
     */
    protected function newArtefact(array $columns, array $originalColumnNames)
    {
        return $this->getSubject()->newArtefact($columns, $originalColumnNames);
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
