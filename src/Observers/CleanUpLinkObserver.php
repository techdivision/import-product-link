<?php

/**
 * TechDivision\Import\Product\Link\Observers\CleanUpLinkObserver
 *
 * PHP version 7
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Observers;

use TechDivision\Import\Subjects\SubjectInterface;
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Observers\ObserverFactoryInterface;
use TechDivision\Import\Product\Link\Utils\ColumnKeys;
use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Link\Utils\ConfigurationKeys;
use TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Observer that cleans-up product link relation information.
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class CleanUpLinkObserver extends AbstractProductImportObserver implements ObserverFactoryInterface
{

    /**
     * The product link processor instance.
     *
     * @var \TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface
     */
    protected $productLinkProcessor;

    /**
     * The array with the link types.
     *
     * @var array
     */
    protected $linkTypes = array();

    /**
     * The flag to query whether or not the link types has to be cleaned-up.
     *
     * @var boolean
     */
    protected $cleanUpLinks = false;

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
     * Will be invoked by the observer visitor when a factory has been defined to create the observer instance.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return \TechDivision\Import\Observers\ObserverInterface The observer instance
     */
    public function createObserver(SubjectInterface $subject)
    {

        // load the link type mappings
        $this->linkTypes = $subject->getLinkTypeMappings();

        // query whether or not the product links has to be cleaned-up
        $this->cleanUpLinks = $subject->getConfiguration()->hasParam(ConfigurationKeys::CLEAN_UP_LINKS) &&
                              $subject->getConfiguration()->getParam(ConfigurationKeys::CLEAN_UP_LINKS, false);

        // return the initialized instance
        return $this;
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
     */
    protected function process()
    {
        // load the row/entity ID of the parent product
        $parentId = $this->getLastPrimaryKey();

        // prepare the links for the found link types and clean-up
        foreach ($this->linkTypes as $linkTypeCode => $columns) {
            // shift the column with the header information from the stack
            list ($columnNameChildSkus, $callbackChildSkus) = array_shift($columns);

            // query whether or not, we've up sell, cross sell or relation products
            $links = $this->getValue($columnNameChildSkus, [], $callbackChildSkus);

            // start the clean-up process, if the appropriate flag has been
            // activated, otherwise we've to figure out if the column value
            // contains the `__EMPTY__VALUE__` constant. In that case,
            // the clean-up columns functionality in the
            // AttributeObserverTrait::clearRow() method has NOT unset the
            // column which indicates the column has to be cleaned-up.
            if ($this->cleanUpLinks === true || ($this->hasColumn($columnNameChildSkus))) {
                // clean-up the links in the database
                $this->doCleanUp($parentId, $linkTypeCode, $links);
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
    protected function doCleanUp($parentProductId, $linkTypeCode, array $childData)
    {

        // load the SKU of the parent product
        $parentSku = $this->getValue(ColumnKeys::SKU);

        // extract the link type code from the row
        $linkTypeId = $this->mapLinkTypeCodeToLinkTypeId($linkTypeCode);

        // remove the old variantes from the database
        $this->getProductLinkProcessor()
            ->deleteProductLink(
                array(
                    MemberNames::PRODUCT_ID   => $parentProductId,
                    MemberNames::SKU          => $childData,
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
