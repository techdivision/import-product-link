<?php

/**
 * TechDivision\Import\Product\Link\Actions\Processors\ProductLinkDeleteProcessor
 *
 * PHP version 7
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Actions\Processors;

use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Link\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Actions\Processors\AbstractBaseProcessor;

/**
 * The product link delete processor implementation.
 *
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-variant
 * @link      http://www.techdivision.com
 */
class ProductLinkDeleteProcessor extends AbstractBaseProcessor
{

    /**
     * Delete all links that are not actual imported
     *
     * @param array       $row                  The row to persist
     * @param string|null $name                 The name of the prepared statement that has to be executed
     * @param string|null $primaryKeyMemberName The primary key member name of the entity to use
     *
     * @return string The ID of the updated entity
     */
    public function execute($row, $name = null, $primaryKeyMemberName = null)
    {

        // load the SKUs from the row
        $skus = $row[MemberNames::SKU];

        // make sure we've an array
        if (!is_array($skus)) {
            $skus = [$skus];
        }

        // all SKUs that should NOT be deleted
        $vals = implode(',', $skus);

        // concatenate the SKUs as comma separated SQL string
        $vals = str_replace(',', "','", "'" . $vals . "'");

        // replace the placeholders
        $sql = str_replace(
            array(':skus', ':product_id', ':link_type_id'),
            array($vals, $row[MemberNames::PRODUCT_ID], $row[MemberNames::LINK_TYPE_ID] ),
            $this->loadStatement(SqlStatementKeys::DELETE_PRODUCT_LINK)
        );

        // delete the links that are NOT in values (take a look at DELETE_PRODUCT_LINK definition)
        $this->getConnection()->query($sql);
    }
}
