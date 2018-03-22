<?php

/**
 * TechDivision\Import\Product\Bundle\Repositories\ProductLinkAttributeIntRepository
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

use TechDivision\Import\Product\Link\Utils\MemberNames;
use TechDivision\Import\Product\Link\Utils\SqlStatementKeys;
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load product link attribute integer data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductLinkAttributeIntRepository extends AbstractRepository implements ProductLinkAttributeIntRepositoryInterface
{

    /**
     * The prepared statement to load a existing product link attribute integer attribute.
     *
     * @var \PDOStatement
     */
    protected $productLinkAttributeIntStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->productLinkAttributeIntStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::PRODUCT_LINK_ATTRIBUTE_INT));
    }

    /**
     * Return's the product link attribute integer value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute integer value
     */
    public function findOneByProductLinkAttributeIdAndLinkId($productLinkAttributeId, $linkId)
    {

        // initialize the params
        $params = array(
            MemberNames::PRODUCT_LINK_ATTRIBUTE_ID => $productLinkAttributeId,
            MemberNames::LINK_ID                   => $linkId
        );

        // load and return the prodcut link attribute integer attribute with the passed product link attribute/link ID
        $this->productLinkAttributeIntStmt->execute($params);
        return $this->productLinkAttributeIntStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
