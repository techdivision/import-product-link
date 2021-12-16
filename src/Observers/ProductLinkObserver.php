<?php

/**
 * TechDivision\Import\Product\Link\Observers\ProductLinkObserver
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
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Prepares the artefacts for the generic link type import.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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

        // load the link type mappings
        $linkTypes = $this->getLinkTypeMappings();

        // prepare the links for the found link types and merge the found artefacts
        foreach ($linkTypes as $linkTypeCode => $columns) {
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

        // load the parent SKU from the row
        $parentSku = $this->getValue(ColumnKeys::SKU);

        // shift the column with the header information from the stack
        list ($columnNameChildSkus, $callbackChildSkus) = array_shift($columns);

        // query whether or not, we've up sell products
        if ($links = $this->getValue($columnNameChildSkus, null, $callbackChildSkus)) {
            // intialize the array for the link attributes
            $linkAttributeValues = array();
            // iterate over the colums to prepare all link type attribute values
            foreach ($columns as $column) {
                // extract the column names and their callbacks
                list ($columnNameLinkTypeAttributeValue, $callbackLinkAttribute, $linkTypeAttributeCode) = $column;

                // explode the link type attributes
                $linkAttributeValues = $this->getValue($columnNameLinkTypeAttributeValue, array(), $callbackLinkAttribute);

                // load the SKUs of the related products
                foreach ($links as $key => $childSku) {
                    // prepare the link type attribute value
                    $linkTypeAttributeValue = $key + 1;
                    if (isset($linkAttributeValues[$key]) && $linkAttributeValues[$key] !== null && $linkAttributeValues[$key] !== '') {
                        $linkTypeAttributeValue = $linkAttributeValues[$key];
                    }

                    // prepare and append the relation to the artefacts
                    $artefacts[] = $this->newArtefact(
                        array(
                            ColumnKeys::LINK_PARENT_SKU           => $parentSku,
                            ColumnKeys::LINK_CHILD_SKU            => $childSku,
                            ColumnKeys::LINK_TYPE_CODE            => $linkTypeCode,
                            ColumnKeys::LINK_TYPE_ATTRIBUTE_CODE  => $linkTypeAttributeCode,
                            ColumnKeys::LINK_TYPE_ATTRIBUTE_VALUE => $linkTypeAttributeValue
                        ),
                        array(
                            ColumnKeys::LINK_PARENT_SKU           => ColumnKeys::SKU,
                            ColumnKeys::LINK_CHILD_SKU            => $columnNameChildSkus,
                            ColumnKeys::LINK_TYPE_CODE            => $columnNameChildSkus,
                            ColumnKeys::LINK_TYPE_ATTRIBUTE_CODE  => $columnNameLinkTypeAttributeValue,
                            ColumnKeys::LINK_TYPE_ATTRIBUTE_VALUE => $columnNameLinkTypeAttributeValue
                        )
                    );
                }
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
    protected function getLinkTypeMappings()
    {
        return $this->getSubject()->getLinkTypeMappings();
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
