<?php

namespace Phpfox\Db;

/**
 * Class SqlDelete
 *
 * @package Phpfox\Db
 */
class SqlDelete
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var SqlCondition
     */
    protected $sqlCondition = null;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param      $expression
     * @param null $data
     *
     * @return $this
     */
    public function where($expression, $data = null)
    {
        if (null == $this->sqlCondition) {
            $this->sqlCondition = new SqlCondition($this->adapter);
        }

        $this->sqlCondition->where($expression, $data);

        return $this;
    }

    /**
     * @param      $expression
     * @param null $data
     *
     * @return $this
     */
    public function orWhere($expression, $data = null)
    {
        if (null == $this->sqlCondition) {
            $this->sqlCondition = new SqlCondition($this->adapter);
        }

        $this->sqlCondition->orWhere($expression, $data);

        return $this;
    }

    /**
     * @param null $sql
     *
     * @return mixed
     * @throws SqlException
     */
    public function execute($sql = null)
    {
        if (null == $sql) {
            $sql = $this->prepare();
        }

        $result = $this->adapter->exec($sql);

        if (false === $result) {
            throw new SqlException($this->adapter->getErrorMessage());
        }

        return $result;
    }

    /**
     * @return string
     */
    public function prepare()
    {
        $where = empty($this->sqlCondition) ? ''
            : ' WHERE ' . $this->sqlCondition->prepare();

        return 'DELETE FROM ' . $this->table . $where;
    }
}