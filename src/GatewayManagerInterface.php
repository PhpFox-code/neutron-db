<?php
namespace Phpfox\Db;


interface GatewayManagerInterface
{
    /**
     * Get a table gateway is associated with key name.
     *
     * @param  string $alias
     *
     * @return TableGatewayInterface
     * @throws GatewayException
     */
    public function get($alias);

    /**
     * @param  string $alias
     *
     * @return TableGatewayInterface
     * @throws GatewayException
     */
    public function build($alias);

    /**
     * @param string                $alias
     * @param TableGatewayInterface $gateway
     *
     * @return $this
     */
    public function set($alias, TableGatewayInterface $gateway);

    /**
     * @param string $alias
     * @param mixed  $id
     *
     * @return mixed|ModelInterface
     * @throws GatewayException
     */
    public function findById($alias, $id);
}