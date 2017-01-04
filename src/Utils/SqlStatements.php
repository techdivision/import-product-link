<?php

/**
 * TechDivision\Import\Product\Link\Utils\SqlStatements
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

namespace TechDivision\Import\Product\Link\Utils;

/**
 * A SSB providing process registry functionality.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class SqlStatements
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * The SQL statement to load an existing product link by product/linked product/link type ID.
     *
     * @var string
     */
    const PRODUCT_LINK = 'SELECT *
                            FROM catalog_product_link
                           WHERE product_id = :product_id
                             AND linked_product_id = :linked_product_id
                             AND link_type_id = :link_type_id';

    /**
     * The SQL statement to load an existing product link attribute integer value by the passed product link attribute ID/link ID/value.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_INT = 'SELECT *
                                          FROM catalog_product_link_attribute_int
                                         WHERE product_link_attribute_id = :product_link_attribute_id
                                           AND link_id = :link_id';

    /**
     * The SQL statement to create a new product link.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK = 'INSERT
                                   INTO catalog_product_link (
                                            product_id,
                                            linked_product_id,
                                            link_type_id
                                        )
                                 VALUES (:product_id,
                                         :linked_product_id,
                                         :link_type_id)';

    /**
     * The SQL statement to update an existing product link.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK = 'UPDATE catalog_product_link
                                    SET product_id = :product_id,
                                        linked_product_id = :linked_product_id,
                                        link_type_id = :link_type_id
                                  WHERE link_id = :link_id';

    /**
     * The SQL statement to create a new product link attribute integer value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_INT = 'INSERT
                                                 INTO catalog_product_link_attribute_int (
                                                          product_link_attribute_id,
                                                          link_id,
                                                          value
                                                      )
                                               VALUES (:product_link_attribute_id,
                                                       :link_id,
                                                       :value)';

    /**
     * The SQL statement to update an existing product link attribute integer value.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK_ATTRIBUTE_INT = 'UPDATE catalog_product_link_attribute_int
                                                  SET product_link_attribute_id = :product_link_attribute_id,
                                                      link_id = :link_id,
                                                      value = :value
                                                WHERE value_id = :value_id';
}
