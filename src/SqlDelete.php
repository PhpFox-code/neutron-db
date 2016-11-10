<?php

namespace Phpfox\Db;

class SqlDelete
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