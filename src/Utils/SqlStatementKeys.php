<?php

/**
 * TechDivision\Import\Product\Link\Utils\SqlStatementKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Product\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to load an existing product link by product/linked product/link type ID.
     *
     * @var string
     */
    const PRODUCT_LINK = 'product_link';

    /**
     * The SQL statement to load an existing product link attribute integer value by the passed product link attribute ID/link ID/value.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_INT = 'product_link_attribute_int';

    /**
     * The SQL statement to load an existing product link attribute decimal value by the passed product link attribute ID/link ID/value.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_DECIMAL = 'product_link_attribute_decimal';

    /**
     * The SQL statement to load an existing product link attribute varchar value by the passed product link attribute ID/link ID/value.
     *
     * @var string
     */
    const PRODUCT_LINK_ATTRIBUTE_VARCHAR = 'product_link_attribute_varchar';

    /**
     * The SQL statement to create a new product link.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK = 'insert.product_link';

    /**
     * The SQL statement to update an existing product link.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK = 'update.product_link';

    /**
     * The SQL statement to update an existing product link attribute varchar value.
     *
     * @var string
     */
    const DELETE_PRODUCT_LINK = 'delete.product_link';

    /**
     * The SQL statement to create a new product link attribute integer value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_INT = 'insert:product_link_attribute_int';

    /**
     * The SQL statement to update an existing product link attribute integer value.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK_ATTRIBUTE_INT = 'update.product_link_attribute_int';

    /**
     * The SQL statement to create a new product link attribute decimal value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL = 'insert:product_link_attribute_decimal';

    /**
     * The SQL statement to update an existing product link attribute decimal value.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL = 'update.product_link_attribute_decimal';

    /**
     * The SQL statement to create a new product link attribute varchar value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR = 'insert:product_link_attribute_varchar';

    /**
     * The SQL statement to update an existing product link attribute varchar value.
     *
     * @var string
     */
    const UPDATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR = 'update.product_link_attribute_varchar';
}
