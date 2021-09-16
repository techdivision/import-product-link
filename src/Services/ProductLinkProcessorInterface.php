<?php

/**
 * TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Services;

use TechDivision\Import\Product\Services\ProductProcessorInterface;

/**
 * Interface for product link processor implementations.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
interface ProductLinkProcessorInterface extends ProductProcessorInterface
{

    /**
     * Return's the repository to load product links.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkRepositoryInterface The repository instance
     */
    public function getProductLinkRepository();

    /**
     * Return's the repository to load product link attribute integer attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeIntRepository();

    /**
     * Return's the repository to load product link attribute decimal attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeDecimalRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeDecimalRepository();

    /**
     * Return's the repository to load product link attribute varchar attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeVarcharRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeVarcharRepository();

    /**
     * Return's the action with the product link CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link CRUD methods
     */
    public function getProductLinkAction();

    /**
     * Return's the action with the product link attribute integer CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute integer CRUD methods
     */
    public function getProductLinkAttributeIntAction();

    /**
     * Return's the action with the product link attribute decimal CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute decimal CRUD methods
     */
    public function getProductLinkAttributeDecimalAction();

    /**
     * Return's the action with the product link attribute varchar CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute varchar CRUD methods
     */
    public function getProductLinkAttributeVarcharAction();

    /**
     * Load's the link with the passed product/linked product/link type ID.
     *
     * @param integer $productId       The product ID of the link to load
     * @param integer $linkedProductId The linked product ID of the link to load
     * @param integer $linkTypeId      The link type ID of the product to load
     *
     * @return array The link
     */
    public function loadProductLink($productId, $linkedProductId, $linkTypeId);

    /**
     * Return's the product link attribute integer value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute integer value
     */
    public function loadProductLinkAttributeInt($productLinkAttributeId, $linkId);

    /**
     * Return's the product link attribute decimal value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute decimal value
     */
    public function loadProductLinkAttributeDecimal($productLinkAttributeId, $linkId);

    /**
     * Return's the product link attribute varchar value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute varchar value
     */
    public function loadProductLinkAttributeVarchar($productLinkAttributeId, $linkId);

    /**
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLink($productLink);

    /**
     * Deletes the passed product link data and return's the ID.
     *
     * @param array       $row  The product link to be deleted
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function deleteProductLink(array $row, $name = null);

    /**
     * Persist's the passed product link attribute integer data.
     *
     * @param array $productLinkAttributeInt The product link attribute integer data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeInt($productLinkAttributeInt);

    /**
     * Persist's the passed product link attribute decimal data.
     *
     * @param array $productLinkAttributeDecimal The product link attribute decimal data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeDecimal($productLinkAttributeDecimal);

    /**
     * Persist's the passed product link attribute varchar data.
     *
     * @param array $productLinkAttributeVarchar The product link attribute varchar data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeVarchar($productLinkAttributeVarchar);
}
