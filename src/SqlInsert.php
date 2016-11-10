<?php

namespace Phpfox\Db;


class SqlInsert
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Sql constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}