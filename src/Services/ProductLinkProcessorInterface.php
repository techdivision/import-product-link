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
     * Return's the repository to load product links.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkRepository The repository instance
     */
    public function getProductLinkRepository();

    /**
     * Return's the repository to load product link attribute integer attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepository The repository instance
     */
    public function getProductLinkAttributeIntRepository();

    /**
     * Return's the action with the product link CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAction The action with the product link CRUD methods
     */
    public function getProductLinkAction();

    /**
     * Return's the action with the product link attribute integer CRUD methods.
     *
     * @return \TechDivision\Import\Product\Link\Actions\ProductLinkAttributeIntAction The action with the product link attribute integer CRUD methods
     */
    public function getProductLinkAttributeIntAction();

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
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLink($productLink);

    /**
     * Persist's the passed product link attribute integer data.
     *
     * @param array $productLinkAttributeInt The product link attribute integer data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLinkAttributeInt($productLinkAttributeInt);
}
