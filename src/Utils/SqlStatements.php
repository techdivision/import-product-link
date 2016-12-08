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

use TechDivision\Import\Utils\SqlStatementsUtil;

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
     * Return's the Magento edition/version specific utility class containing
     * the SQL statements to use.
     *
     * @param string $magentoEdition The Magento edition to use, EE or CE
     * @param string $magentoVersion The Magento version to use, e. g. 2.1.0
     *
     * @return string The fully qualified utility class name
     */
    public static function getUtilityClassName($magentoEdition, $magentoVersion)
    {

        // format Magento edition/version to build a valid PHP namespace
        $magentoEdition = SqlStatementsUtil::formatMagentoEdition($magentoEdition);
        $magentoVersion = SqlStatementsUtil::formatMagentoVersion($magentoVersion);

        // prepare the Magento edition/version specific utility classname
        $utilClassName = sprintf('TechDivision\Import\Product\Variant\Utils\%s\V%s\SqlStatements', $magentoEdition, $magentoVersion);

        // if NOT available, use the default utility class name
        if (!class_exists($utilClassName)) {
            // prepare the Magento edition/version specific utility classname
            if (!class_exists($utilClassName = sprintf('TechDivision\Import\Product\Variant\Utils\%s\SqlStatements', $magentoEdition))) {
                $utilClassName = __CLASS__;
            }
        }

        // return the utility class name
        return $utilClassName;
    }

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
                                 VALUES (?, ?, ?)';

    /**
     * The SQL statement to create a new product link attribute.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE = 'INSERT
                                             INTO catalog_product_link_attribute (
                                                      link_type_id,
                                                      product_link_attribute_code,
                                                      data_type,
                                                  )
                                           VALUES (?, ?, ?)';

    /**
     * The SQL statement to create a new product link attribute decimal value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL = 'INSERT
                                                     INTO catalog_product_link_attribute_decimal (
                                                              product_link_attribute_id,
                                                              link_id,
                                                              value,
                                                          )
                                                   VALUES (?, ?, ?)';

    /**
     * The SQL statement to create a new product link attribute integer value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_INT = 'INSERT
                                                 INTO catalog_product_link_attribute_int (
                                                          product_link_attribute_id,
                                                          link_id,
                                                          value,
                                                      )
                                               VALUES (?, ?, ?)';

    /**
     * The SQL statement to create a new product link attribute varchar value.
     *
     * @var string
     */
    const CREATE_PRODUCT_LINK_ATTRIBUTE_VARCHAR = 'INSERT
                                                     INTO catalog_product_link_attribute_varchar (
                                                              product_link_attribute_id,
                                                              link_id,
                                                              value,
                                                          )
                                                   VALUES (?, ?, ?)';

}