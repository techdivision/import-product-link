<?php

/**
 * TechDivision\Import\Product\Link\Services\ProductLinkProcessorInterface
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

namespace TechDivision\Import\Product\Link\Services;

use TechDivision\Import\Product\Services\ProductProcessorInterface;

/**
 * A SLSB providing methods to load product data using a PDO connection.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
interface ProductLinkProcessorInterface extends ProductProcessorInterface
{

    /**
     * Return's the action with the product link CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkGalleryAction The action with the product link CRUD methods
     */
    public function getProductLinkAction();

    /**
     * Return's the action with the product link attribute CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAttributeAction The action with the product link attribute CRUD methods
     */
    public function getProductLinkAttributeAction();

    /**
     * Return's the action with the product link attribute decimal CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAttributeDecimalAction The action with the product link attribute decimal CRUD methods
     */
    public function getProductLinkAttributeDecimalAction();

    /**
     * Return's the action with the product link attribute integer CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAttributeIntAction The action with the product link attribute integer CRUD methods
     */
    public function getProductLinkAttributeIntAction();

    /**
     * Return's the action with the product link attribute varchar CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAttributeVarcharAction The action with the product link attribute varchar CRUD methods
     */
    public function getProductLinkAttributeVarcharAction();

    /**
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLink($productLink);

    /**
     * Persist's the passed product link attribute data and return's the ID.
     *
     * @param array $productLinkAttribute The product link attribute data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttribute($productLinkAttribute);

    /**
     * Persist's the passed product link attribute decimal data.
     *
     * @param array $productLinkAttributeDecimal The product link attribute decimal data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeDecimal($productLinkAttributeDecimal);

    /**
     * Persist's the passed product link attribute integer data.
     *
     * @param array $productLinkAttributeInt The product link attribute integer data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttributeInt($productLinkAttributeInt);

    /**
     * Persist's the passed product link attribute varchar data.
     *
     * @param array $productLinkAttributeVarchar The product link attribute varchar data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttributeVarchar($productLinkAttributeVarchar);
}
