<?php

namespace Phpfox\Db;

use Phpfox\Mysqli\DbAdapter;
use PHPUnit_Framework_TestCase;

/**
 * Created by PhpStorm.
 * User: namnv
 * Date: 11/17/16
 * Time: 3:42 PM
 */
class SqlConditionTest extends PHPUnit_Framework_TestCase
{

    public function testTransaction()
    {
        $adapter = $this->getAdapter();

        $this->assertNotNull($conn = $adapter->getMaster());

        $this->assertFalse($conn->isInTransaction());

        $conn->begin();

        $this->assertTrue($conn->isInTransaction());

        $conn->commit();

        $this->assertFalse($conn->isInTransaction());

        $conn->begin();

        $this->assertTrue($conn->isInTransaction());

        $conn->rollback();

        $this->assertFalse($conn->isInTransaction());
    }

    public function getAdapter()
    {
        return new DbAdapter([
            'host'     => '127.0.0.1',
            'port'     => 33306,
            'username' => 'root',
            'password' => 'namnv123',
            'database' => 'phpfox_unitest',
        ]);
    }

    public function testSqlSelect()
    {
        $adapter = $this->getAdapter();

        $sqlSelect = new SqlSelect($adapter);

        $sqlResult = $sqlSelect->select('*')->select('user_id')
            ->from('phpfox_user')->where('user_id=1')->execute();

        echo $sqlSelect->prepare();
        // Could not execute the query.

        $this->assertTrue($sqlResult->isValid());

        $sqlResult->fetch();
    }

    public function testSqlInsert()
    {
        $adapter = $this->getAdapter();

        $sqlUpdate = new SqlUpdate($adapter);

        $sqlUpdate->update('phpfox_user', ['username' => 'namnv'])
            ->where('user_id=?', 1);

        echo $sqlUpdate->prepare();


    }
}

