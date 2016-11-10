<?php

namespace Phpfox\Db;

/**
 * Interface ConnectionInterface
 *
 * @package Phpfox\Db
 */
interface ConnectionInterface
{
    /**
     * @param mixed $params
     */
    public function __construct($params);

    /**
     * Get connection resource
     *
     * @return mixed
     */
    public function getResource();

    /**
     * Overwrite Resource
     *
     * @param mixed $resource
     *
     * @return $this
     */
    public function setResource($resource);


    /**
     * @return $this
     */
    public function connect();

    /**
     * @return $this
     */
    public function disconnect();

    /**
     * Check connect status
     *
     * @return bool
     */
    public function isConnected();

    /**
     * @return $this
     */
    public function ensureConnected();

    /**
     * Is this connection is in transaction
     *
     * @return bool
     */
    public function isInTransaction();

    /**
     * @return $this
     */
    public function begin();

    /**
     * @return $this
     */
    public function commit();

    /**
     * @return $this
     */
    public function rollback();

    /**
     * @return int|null
     */
    public function lastId();

    /**
     * @param string $sql
     *
     * @return QueryResultInterface
     */
    public function execute($sql);

    /**
     * @param mixed $value
     *
     * @return QueryResultInterface
     */
    public function createResult($value);

    /**
     * Get platform name
     *
     * @return string
     */
    public function getPlatformName();
}