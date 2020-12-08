<?php

/**
 * TechDivision\Import\Product\Link\Observers\CleanUpLinkObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Observers;

use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface;
use TechDivision\Import\Product\Link\Utils\ColumnKeys;
use TechDivision\Import\Product\Link\Utils\ConfigurationKeys;
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Observer that cleaned up a product's link information.
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class CleanUpLinkObserver extends AbstractProductImportObserver
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
     * @param \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface $productLinkProcessor The
     *                                                                                                       product link processor instance
     * @param StateDetectorInterface|null                                              $stateDetector        The state detector instance to use
     */
    public function __construct(
        ProductLinkProcessorInterface $productLinkProcessor,
        StateDetectorInterface $stateDetector = null
    ) {

        // pass the state detector to the parent constructor
        parent::__construct($stateDetector);

        // initialize the product link processor instance
        $this->productLinkProcessor = $productLinkProcessor;
    }

    /**
     * Return's the product variant processor instance.
     *
     * @return \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface The product variant processor
     *     instance
     */
    protected function getProductLinkProcessor()
    {
        return $this->productLinkProcessor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return void
     * @throws \Exception
     */
    protected function process()
    {

        // query whether or not the product links has to be cleaned up
        if ($this->getSubject()->getConfiguration()->hasParam(ConfigurationKeys::CLEAN_UP_LINKS)
            && $this->getSubject()->getConfiguration()->getParam(ConfigurationKeys::CLEAN_UP_LINKS)
        ) {
            // load the row/entity ID of the parent product
            $parentId = $this->getLastPrimaryKey();

            // load the link type mappings
            $linkTypes = $this->getSubject()->getLinkTypeMappings();

            // prepare the links for the found link types and clean up
            foreach ($linkTypes as $linkTypeCode => $columns) {
                // shift the column with the header information from the stack
                list ($columnNameChildSkus, $callbackChildSkus) = array_shift($columns);

                // query whether or not, we've up sell, cross sell or relation products
                $links = $this->getValue($columnNameChildSkus, [], $callbackChildSkus);

                // Start clean up
                $this->cleanUpLinks($parentId, $linkTypeCode, $links);
            }
        }
    }

    /**
     * Delete not exists import links from database.
     *
     * @param int    $parentProductId The ID of the parent product
     * @param string $linkTypeCode    The link type code to prepare the artefacts for
     * @param array  $childData       The array of variants
     *
     * @return void
     */
    protected function cleanUpLinks($parentProductId, $linkTypeCode, array $childData)
    {
        // we maybe don't want delete everything
        if (empty($childData)) {
            return;
        }

        // load the SKU of the parent product
        $parentSku = $this->getValue(ColumnKeys::SKU);

        // extract the link type code from the row
        $linkTypeId = $this->mapLinkTypeCodeToLinkTypeId($linkTypeCode);

        // remove the old variantes from the database
        $this->getProductLinkProcessor()
            ->deleteProductLink(
                array(
                    MemberNames::PRODUCT_ID => $parentProductId,
                    MemberNames::SKU => $childData,
                    MemberNames::LINK_TYPE_ID => $linkTypeId,
                )
            );

        // log a debug message that the image has been removed
        $this->getSubject()
            ->getSystemLogger()
            ->debug(
                $this->getSubject()->appendExceptionSuffix(
                    sprintf(
                        'Successfully clean up links for product with SKU "%s" except "%s"',
                        $parentSku,
                        implode(', ', $childData)
                    )
                )
            );
    }

    /**
     * Return's the PK to create the product => variant relation.
     *
     * @return integer The PK to create the relation with
     */
    protected function getLastPrimaryKey()
    {
        return $this->getLastEntityId();
    }

    /**
     * Return the link type ID for the passed link type code.
     *
     * @param string $linkTypeCode The link type code to return the link type ID for
     *
     * @return integer The mapped link type ID
     * @throws \TechDivision\Import\Product\Exceptions\MapLinkTypeCodeToIdException Is thrown if the link type code is
     *     not mapped yet
     */
    protected function mapLinkTypeCodeToLinkTypeId($linkTypeCode)
    {
        return $this->getSubject()->mapLinkTypeCodeToLinkTypeId($linkTypeCode);
    }
}
