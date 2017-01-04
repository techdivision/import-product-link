<?php

/**
 * TechDivision\Import\Product\Link\Repositories\ProductLinkAction
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

namespace TechDivision\Import\Product\Link\Actions;

use TechDivision\Import\Utils\EntityStatus;
use TechDivision\Import\Actions\AbstractAction;

/**
 * An action implementation that provides CRUD functionality for product links.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductLinkAction extends AbstractAction
{

    /**
     * Helper method that create/update the passed entity, depending on
     * the entity's status.
     *
     * @param array $row The entity data to create/update
     *
     * @return string The last inserted ID
     */
    public function persist(array $row)
    {

        // load the method name
        $methodName = $row[EntityStatus::MEMBER_NAME];

        // invoke the method
        return $this->$methodName($row);
    }

    /**
     * Creates's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to create
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The last inserted ID
     */
    public function create($row, $name = null)
    {
        return $this->getCreateProcessor()->execute($row, $name);
    }

    /**
     * Update's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to update
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the updated product
     */
    public function update($row, $name = null)
    {
        return $this->getUpdateProcessor()->execute($row, $name);
    }
}
