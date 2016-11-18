<?php

namespace Phpfox\Db;

/**
 * Class TableGatewayInterface
 *
 * @package Phpfox\Db
 */
interface TableGatewayInterface
{
    /**
     * @param mixed $id
     *
     * @return mixed
     * @throws GatewayException
     */
    public function findById($id);
}