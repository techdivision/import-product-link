<?php

/**
 * TechDivision\Import\Product\Bundle\Repositories\ProductLinkRepository
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
 * Repository implementation to load product link data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductLinkRepository extends AbstractRepository implements ProductLinkRepositoryInterface
{

    /**
     * The prepared statement to load a existing product link.
     *
     * @var \PDOStatement
     */
    protected $linkStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->productLinkStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::PRODUCT_LINK));
    }

    /**
     * Load's the product link with the passed product/linked product/link type ID.
     *
     * @param integer $productId       The product ID of the link to load
     * @param integer $linkedProductId The linked product ID of the link to load
     * @param integer $linkTypeId      The link type ID of the product to load
     *
     * @return array The link
     */
    public function findOneByProductIdAndLinkedProductIdAndLinkTypeId($productId, $linkedProductId, $linkTypeId)
    {

        // initialize the params
        $params = array(
            MemberNames::PRODUCT_ID        => $productId,
            MemberNames::LINKED_PRODUCT_ID => $linkedProductId,
            MemberNames::LINK_TYPE_ID      => $linkTypeId
        );

        // load and return the prodcut link with the passed product/linked product/link type ID
        $this->productLinkStmt->execute($params);
        return $this->productLinkStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
