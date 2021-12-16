<?php

/**
 * TechDivision\Import\Product\Link\Repositories\SqlStatements
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
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
 * @license   https://opensource.org/licenses/MIT
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
               FROM ${table:catalog_product_link}
              WHERE product_id = :product_id
                AND linked_product_id = :linked_product_id
                AND link_type_id = :link_type_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_INT =>
            'SELECT *
               FROM ${table:catalog_product_link_attribute_int}
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'SELECT *
               FROM ${table:catalog_product_link_attribute_decimal}
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'SELECT *
               FROM ${table:catalog_product_link_attribute_varchar}
              WHERE product_link_attribute_id = :product_link_attribute_id
                AND link_id = :link_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK =>
            'INSERT
               INTO ${table:catalog_product_link}
                    (product_id,
                     linked_product_id,
                     link_type_id)
             VALUES (:product_id,
                     :linked_product_id,
                     :link_type_id)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK =>
            'UPDATE ${table:catalog_product_link}
                SET product_id = :product_id,
                    linked_product_id = :linked_product_id,
                    link_type_id = :link_type_id
              WHERE link_id = :link_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_INT =>
            'INSERT
               INTO ${table:catalog_product_link_attribute_int}
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_INT =>
            'UPDATE ${table:catalog_product_link_attribute_int}
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'INSERT
               INTO ${table:catalog_product_link_attribute_decimal}
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL =>
            'UPDATE ${table:catalog_product_link_attribute_decimal}
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'INSERT
               INTO ${table:catalog_product_link_attribute_varchar}
                    (product_link_attribute_id,
                     link_id,
                     value)
             VALUES (:product_link_attribute_id,
                     :link_id,
                     :value)',
        SqlStatementKeys::UPDATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR =>
            'UPDATE ${table:catalog_product_link_attribute_varchar}
                SET product_link_attribute_id = :product_link_attribute_id,
                    link_id = :link_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_PRODUCT_LINK =>
            'DELETE
               FROM ${table:catalog_product_link}
              WHERE product_id = :product_id
                AND link_type_id = :link_type_id
                AND linked_product_id
             NOT IN (SELECT entity_id FROM catalog_product_entity WHERE sku IN (:skus))',
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
