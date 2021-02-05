<?php

/**
 * TechDivision\Import\Product\Link\Actions\Processors\ProductLinkAttributeDecimalCreateProcessor
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
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Actions\Processors;

use TechDivision\Import\Product\Link\Utils\SqlStatementKeys;
use TechDivision\Import\Actions\Processors\AbstractCreateProcessor;

/**
 * The product link attribute decimal create processor implementation.
 *
 * @author     Tim Wagner <t.wagner@techdivision.com>
 * @copyright  2021 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       https://github.com/techdivision/import-product-link
 * @link       http://www.techdivision.com
 * @deprecated Since 24.0.0
 * @see        \TechDivision\Import\Actions\Processors\GenericProcessor
 */
class ProductLinkAttributeDecimalCreateProcessor extends AbstractCreateProcessor
{

    /**
     * Return's the array with the SQL statements that has to be prepared.
     *
     * @return array The SQL statements to be prepared
     * @see \TechDivision\Import\Actions\Processors\AbstractBaseProcessor::getStatements()
     */
    protected function getStatements()
    {

        // return the array with the SQL statements that has to be prepared
        return array(
            SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL => $this->loadStatement(SqlStatementKeys::CREATE_PRODUCT_LINK_ATTRIBUTE_DECIMAL)
        );
    }
}
