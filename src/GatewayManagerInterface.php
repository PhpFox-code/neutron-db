<?php
namespace Phpfox\Db;


interface GatewayManagerInterface
{
    /**
     * Get a table gateway is associated with key name.
     *
     * @param  string $id
     *
     * @return TableGatewayInterface
     * @throws GatewayException
     */
    public function get($id);

    /**
     * @param  string $id
     *
     * @return TableGatewayInterface
     * @throws GatewayException
     */
    public function build($id);

    /**
     * @param string                $id
     * @param TableGatewayInterface $gateway
     *
     * @return $this
     */
    public function set($id, TableGatewayInterface $gateway);
}