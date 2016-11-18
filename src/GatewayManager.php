<?php

namespace Phpfox\Db;

class GatewayManager implements GatewayManagerInterface
{
    /**
     * @var TableGatewayInterface[]
     */
    protected $tables = [];

    /**
     * @var string[]
     */
    protected $map = [];

    /**
     * @param string $alias
     *
     * @return TableGatewayInterface
     */
    public function get($alias)
    {
        return isset($this->tables[$alias]) ? $this->tables[$alias]
            : $this->tables[$alias] = $this->build($alias);
    }

    public function build($alias)
    {
        if (!isset($this->map[$alias])
            || !class_exists($this->map[$alias][0])
        ) {
            throw new GatewayException("gateway `$alias` does not exists");
        }

        list($table, $model, $name) = $this->map[$alias];

        if (!class_exists($table) || !class_exists($model)) {
            throw new GatewayException("gateway `$alias` does not exists");
        }

        return new $table($name, $model);
    }

    public function set($alias, TableGatewayInterface $gateway)
    {
        $this->tables[$alias] = $gateway;
        return $this;
    }

    public function findById($alias, $id)
    {
        return $this->get($alias)->findById($id);
    }
}