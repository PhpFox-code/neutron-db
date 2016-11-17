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
     * @param string $id
     *
     * @return TableGatewayInterface
     */
    public function get($id)
    {
        return isset($this->tables[$id]) ? $this->tables[$id]
            : $this->tables[$id] = $this->build($id);
    }

    public function build($id)
    {
        if (!isset($this->map[$id]) || !class_exists($this->map[$id])) {
            throw new GatewayException("gateway ($id) does not exists");
        }


        return new ($this->map[$id])();
    }

    public function set($id, TableGatewayInterface $gateway)
    {
        $this->tables[$id] = $gateway;
        return $this;
    }
}