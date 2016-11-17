<?php

namespace Phpfox\Db;

/**
 * Interface AdapterInterface
 *
 * @package Phpfox\Db
 */
interface AdapterInterface
{
    /**
     * @return \mysqli
     */
    public function getMaster();

    /**
     * @return \mysqli
     */
    public function getSlave();

    /**
     * @param $value
     *
     * @return mixed
     */
    public function quoteValue($value);

    /**
     * @param string $value
     *
     * @return string mixed
     */
    public function quoteIdentifier($value);

    /**
     * @param $string
     *
     * @return string
     */
    public function escape($string);

    /**
     * @param string $sql
     * @param bool   $master
     *
     * @return SqlResultInterface
     */
    public function query($sql, $master = true);

    /**
     * @param string $sql
     * @param bool   $master Use master connection
     *
     * @return mixed
     */
    public function exec($sql, $master = true);

    /**
     * @return int
     */
    public function lastId();

    /**
     * @return SqlSelect
     */
    public function select();

    /**
     * @param $table
     * @param $data
     *
     * @return SqlInsert
     */
    public function insert($table, $data);

    /**
     * @param $table
     * @param $data
     *
     * @return SqlUpdate
     */
    public function update($table, $data);

    /**
     * @param string $table
     *
     * @return SqlDelete
     */
    public function delete($table);

    /**
     * @param bool|true $master Use master connection
     *
     * @return string
     */
    public function getErrorMessage($master = true);

    /**
     * @param bool|true $master
     *
     * @return mixed
     */
    public function getErrorCode($master = true);

    /**
     * @param $table
     *
     * @return string
     */
    public function getCreateTableSql($table);

    /**
     * @param string $table
     *
     * @return array
     */
    public function describe($table);

    /**
     * @return mixed
     */
    public function startTransaction();

    /**
     * commit transaction
     */
    public function commit();

    /**
     * roll back
     */
    public function rollback();

    /**
     * @return true
     */
    public function inTransaction();

}