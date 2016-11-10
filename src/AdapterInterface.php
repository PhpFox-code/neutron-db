<?php

namespace Phpfox\Db;


interface AdapterInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function quoteValue($value);

    /**
     * @param string $name
     *
     * @return string
     */
    public function quoteIdentifier($name);

    /**
     * Master Connection
     *
     * @return ConnectionInterface
     */
    public function getMaster();

    /**
     * Slave Connection
     *
     * @return ConnectionInterface
     */
    public function getSlave();

    /**
     * @return mixed
     */
    public function getPlatformName();
}