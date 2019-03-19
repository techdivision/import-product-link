<?php

/**
 * TechDivision\Import\Product\Link\Repositories\SqlStatements
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

namespace TechDivision\Import\Product\Link\Repositories;

use TechDivision\Import\Product\Link\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Product\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::PRODUCT_LINK =>
            'SELECT *
               FROM catalog_product_link
              WHERE product_id = :product_id
                AND linked_product_id = :linked_product_id
                AND link_type_id = :link_type_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_INT =>
            'SELECT *
               FROM catalog_product_link_attribute_int
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'SELECT *
               FROM catalog_product_link_attribute_decimal
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'SELECT *
               FROM catalog_product_link_attribute_varchar
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK =>
            'INSERT
               INTO catalog_product_link
                    (product_id,
                     linked_product_id,
                     link_type_id)
             VALUES (:product_id,
                     :linked_product_id,
                     :link_type_id)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK =>
            'UPDATE catalog_product_link
                SET product_id = :product_id,
                    linked_product_id = :linked_product_id,
                    link_type_id = :link_type_id
              WHERE link_id = :link_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_INT =>
            'INSERT
               INTO catalog_product_link_attribute_int
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_INT =>
            'UPDATE catalog_product_link_attribute_int
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'INSERT
               INTO catalog_product_link_attribute_decimal
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'UPDATE catalog_product_link_attribute_decimal
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'INSERT
               INTO catalog_product_link_attribute_varchar
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'UPDATE catalog_product_link_attribute_varchar
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id'
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
