<?php

/**
 * TechDivision\Import\Product\Link\Services\ProductLinkProcessor
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Link\Services;

use TechDivision\Import\Dbal\Actions\ActionInterface;
use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Product\Link\Repositories\ProductLinkRepositoryInterface;
use TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepositoryInterface;
use TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeDecimalRepositoryInterface;
use TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeVarcharRepositoryInterface;

/**
 * The product link processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductLinkProcessor implements ProductLinkProcessorInterface
{

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var \TechDivision\Import\Dbal\Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * The repository to load product links.
     *
     * @var \TechDivision\Import\Product\Link\Repositories\ProductLinkRepositoryInterface
     */
    protected $productLinkRepository;

    /**
     * The repository to load product link attribute integer attributes.
     *
     * @var \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepositoryInterface
     */
    protected $productLinkAttributeIntRepository;

    /**
     * The repository to load product link attribute decimal attributes.
     *
     * @var \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeDecimalRepositoryInterface
     */
    protected $productLinkAttributeDecimalRepository;

    /**
     * The repository to load product link attribute varchar attributes.
     *
     * @var \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeVarcharRepositoryInterface
     */
    protected $productLinkAttributeVarcharRepository;

    /**
     * The action with the product link CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $productLinkAction;

    /**
     * The action with the product link attribute integer CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $productLinkAttributeIntAction;

    /**
     * The action with the product link attribute deciam CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $productLinkAttributeDecimalAction;

    /**
     * The action with the product link attribute varchar CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $productLinkAttributeVarcharAction;

    /**
     * Initialize the processor with the necessary assembler and repository instances.
     *
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface                                       $connection                            The connection to use
     * @param \TechDivision\Import\Product\Link\Repositories\\ProductLinkRepositoryInterface                 $productLinkRepository                 The product link repository to use
     * @param \TechDivision\Import\Product\Link\Repositories\\ProductLinkAttributeIntRepositoryInterface     $productLinkAttributeIntRepository     The product link attribute integer repository to use
     * @param \TechDivision\Import\Product\Link\Repositories\\ProductLinkAttributeDecimalRepositoryInterface $productLinkAttributeDecimalRepository The product link attribute decimal repository to use
     * @param \TechDivision\Import\Product\Link\Repositories\\ProductLinkAttributeVarcharRepositoryInterface $productLinkAttributeVarcharRepository The product link attribute varchar repository to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                              $productLinkAction                     The product link action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                              $productLinkAttributeIntAction         The product link attribute integer action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                              $productLinkAttributeDecimalAction     The product link attribute decimal action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                              $productLinkAttributeVarcharAction     The product link attribute varchar action to use
     */
    public function __construct(
        ConnectionInterface $connection,
        ProductLinkRepositoryInterface $productLinkRepository,
        ProductLinkAttributeIntRepositoryInterface $productLinkAttributeIntRepository,
        ProductLinkAttributeDecimalRepositoryInterface $productLinkAttributeDecimalRepository,
        ProductLinkAttributeVarcharRepositoryInterface $productLinkAttributeVarcharRepository,
        ActionInterface $productLinkAction,
        ActionInterface $productLinkAttributeIntAction,
        ActionInterface $productLinkAttributeDecimalAction,
        ActionInterface $productLinkAttributeVarcharAction
    ) {
        $this->setConnection($connection);
        $this->setProductLinkRepository($productLinkRepository);
        $this->setProductLinkAttributeIntRepository($productLinkAttributeIntRepository);
        $this->setProductLinkAttributeDecimalRepository($productLinkAttributeDecimalRepository);
        $this->setProductLinkAttributeVarcharRepository($productLinkAttributeVarcharRepository);
        $this->setProductLinkAction($productLinkAction);
        $this->setProductLinkAttributeIntAction($productLinkAttributeIntAction);
        $this->setProductLinkAttributeDecimalAction($productLinkAttributeDecimalAction);
        $this->setProductLinkAttributeVarcharAction($productLinkAttributeVarcharAction);
    }

    /**
     * Set's the passed connection.
     *
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface $connection The connection to set
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return \TechDivision\Import\Dbal\Connection\ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling ProductProcessor::commit().
     * Calling ProductProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * ProductProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by ProductProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the repository to load product links.
     *
     * @param \TechDivision\Import\Product\Link\Repositories\ProductLinkRepositoryInterface $productLinkRepository The repository instance
     *
     * @return void
     */
    public function setProductLinkRepository(ProductLinkRepositoryInterface $productLinkRepository)
    {
        $this->productLinkRepository = $productLinkRepository;
    }

    /**
     * Return's the repository to load product links.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkRepositoryInterface The repository instance
     */
    public function getProductLinkRepository()
    {
        return $this->productLinkRepository;
    }

    /**
     * Set's the repository to load product link attribute integer attributes.
     *
     * @param \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepositoryInterface $productLinkAttributeIntRepository The repository instance
     *
     * @return void
     */
    public function setProductLinkAttributeIntRepository(ProductLinkAttributeIntRepositoryInterface $productLinkAttributeIntRepository)
    {
        $this->productLinkAttributeIntRepository = $productLinkAttributeIntRepository;
    }

    /**
     * Return's the repository to load product link attribute integer attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeIntRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeIntRepository()
    {
        return $this->productLinkAttributeIntRepository;
    }

    /**
     * Set's the repository to load product link attribute decimal attributes.
     *
     * @param \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeDecimalRepositoryInterface $productLinkAttributeDecimalRepository The repository instance
     *
     * @return void
     */
    public function setProductLinkAttributeDecimalRepository(ProductLinkAttributeDecimalRepositoryInterface $productLinkAttributeDecimalRepository)
    {
        $this->productLinkAttributeDecimalRepository = $productLinkAttributeDecimalRepository;
    }

    /**
     * Return's the repository to load product link attribute decimal attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeDecimalRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeDecimalRepository()
    {
        return $this->productLinkAttributeDecimalRepository;
    }

    /**
     * Set's the repository to load product link attribute varchar attributes.
     *
     * @param \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeVarcharRepositoryInterface $productLinkAttributeVarcharRepository The repository instance
     *
     * @return void
     */
    public function setProductLinkAttributeVarcharRepository(ProductLinkAttributeVarcharRepositoryInterface $productLinkAttributeVarcharRepository)
    {
        $this->productLinkAttributeVarcharRepository = $productLinkAttributeVarcharRepository;
    }

    /**
     * Return's the repository to load product link attribute varchar attributes.
     *
     * @return \TechDivision\Import\Product\Link\Repositories\ProductLinkAttributeVarcharRepositoryInterface The repository instance
     */
    public function getProductLinkAttributeVarcharRepository()
    {
        return $this->productLinkAttributeVarcharRepository;
    }

    /**
     * Set's the action with the product link CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $productLinkAction The action with the product link CRUD methods
     *
     * @return void
     */
    public function setProductLinkAction(ActionInterface $productLinkAction)
    {
        $this->productLinkAction = $productLinkAction;
    }

    /**
     * Return's the action with the product link CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link CRUD methods
     */
    public function getProductLinkAction()
    {
        return $this->productLinkAction;
    }

    /**
     * Set's the action with the product link attribute integer CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $productLinkAttributeIntAction The action with the product link attribute integer CRUD methods
     *
     * @return void
     */
    public function setProductLinkAttributeIntAction(ActionInterface $productLinkAttributeIntAction)
    {
        $this->productLinkAttributeIntAction = $productLinkAttributeIntAction;
    }

    /**
     * Return's the action with the product link attribute integer CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute integer CRUD methods
     */
    public function getProductLinkAttributeIntAction()
    {
        return $this->productLinkAttributeIntAction;
    }

    /**
     * Set's the action with the product link attribute decimal CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $productLinkAttributeDecimalAction The action with the product link attribute decimal CRUD methods
     *
     * @return void
     */
    public function setProductLinkAttributeDecimalAction(ActionInterface $productLinkAttributeDecimalAction)
    {
        $this->productLinkAttributeDecimalAction = $productLinkAttributeDecimalAction;
    }

    /**
     * Return's the action with the product link attribute decimal CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute decimal CRUD methods
     */
    public function getProductLinkAttributeDecimalAction()
    {
        return $this->productLinkAttributeDecimalAction;
    }

    /**
     * Set's the action with the product link attribute varchar CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $productLinkAttributeVarcharAction The action with the product link attribute varchar CRUD methods
     *
     * @return void
     */
    public function setProductLinkAttributeVarcharAction(ActionInterface $productLinkAttributeVarcharAction)
    {
        $this->productLinkAttributeVarcharAction = $productLinkAttributeVarcharAction;
    }

    /**
     * Return's the action with the product link attribute varchar CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action with the product link attribute varchar CRUD methods
     */
    public function getProductLinkAttributeVarcharAction()
    {
        return $this->productLinkAttributeVarcharAction;
    }

    /**
     * Load's the link with the passed product/linked product/link type ID.
     *
     * @param integer $productId       The product ID of the link to load
     * @param integer $linkedProductId The linked product ID of the link to load
     * @param integer $linkTypeId      The link type ID of the product to load
     *
     * @return array The link
     */
    public function loadProductLink($productId, $linkedProductId, $linkTypeId)
    {
        return $this->getProductLinkRepository()->findOneByProductIdAndLinkedProductIdAndLinkTypeId($productId, $linkedProductId, $linkTypeId);
    }

    /**
     * Return's the product link attribute integer value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute integer value
     */
    public function loadProductLinkAttributeInt($productLinkAttributeId, $linkId)
    {
        return $this->getProductLinkAttributeIntRepository()->findOneByProductLinkAttributeIdAndLinkId($productLinkAttributeId, $linkId);
    }

    /**
     * Return's the product link attribute decimal value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute decimal value
     */
    public function loadProductLinkAttributeDecimal($productLinkAttributeId, $linkId)
    {
        return $this->getProductLinkAttributeDecimalRepository()->findOneByProductLinkAttributeIdAndLinkId($productLinkAttributeId, $linkId);
    }

    /**
     * Return's the product link attribute varchar value with the passed product link attribute/link ID.
     *
     * @param integer $productLinkAttributeId The product link attribute ID of the attributes
     * @param integer $linkId                 The link ID of the attribute
     *
     * @return array The product link attribute varchar value
     */
    public function loadProductLinkAttributeVarchar($productLinkAttributeId, $linkId)
    {
        return $this->getProductLinkAttributeVarcharRepository()->findOneByProductLinkAttributeIdAndLinkId($productLinkAttributeId, $linkId);
    }

    /**
     * Persist's the passed product link data and return's the ID.
     *
     * @param array $productLink The product link data to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistProductLink($productLink)
    {
        return $this->getProductLinkAction()->persist($productLink);
    }

    /**
     * Delete's the passed product link data.
     *
     * @param array       $row  The product link to be deleted
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function deleteProductLink(array $row, $name = null)
    {
        return $this->getProductLinkAction()->delete($row, $name);
    }

    /**
     * Persist's the passed product link attribute integer data.
     *
     * @param array $productLinkAttributeInt The product link attribute integer data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeInt($productLinkAttributeInt)
    {
        $this->getProductLinkAttributeIntAction()->persist($productLinkAttributeInt);
    }

    /**
     * Persist's the passed product link attribute decimal data.
     *
     * @param array $productLinkAttributeDecimal The product link attribute decimal data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeDecimal($productLinkAttributeDecimal)
    {
        $this->getProductLinkAttributeDecimalAction()->persist($productLinkAttributeDecimal);
    }

    /**
     * Persist's the passed product link attribute varchar data.
     *
     * @param array $productLinkAttributeVarchar The product link attribute varchar data to persist
     *
     * @return void
     */
    public function persistProductLinkAttributeVarchar($productLinkAttributeVarchar)
    {
        $this->getProductLinkAttributeVarcharAction()->persist($productLinkAttributeVarchar);
    }
}
