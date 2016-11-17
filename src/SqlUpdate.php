<?php


namespace Phpfox\Db;

/**
 * Class SqlUpdate
 *
 * @package Phpfox\Db
 */
class SqlUpdate
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $_tableName;

    /**
     * @var array
     */
    protected $_data = [];

    /**
     * @var SqlCondition
     */
    protected $_where = null;

    /**
     * SqlUpdate constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $tableName
     * @param array  $data
     *
     * @return $this
     */
    public function update($tableName, $data)
    {
        $this->_tableName = $tableName;
        $this->_data = $data;

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
        if (null == $this->_where) {
            $this->_where = new SqlCondition($this->adapter);
        }

        $this->_where->where($expression, $data);

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
        if (null == $this->_where) {
            $this->_where = new SqlCondition($this->adapter);
        }

        $this->_where->orWhere($expression, $data);

        return $this;
    }

    /**
     * @param null $sql
     *
     * @return mixed
     * @throws DbException
     */
    public function execute($sql = null)
    {
        if (null == $sql) {
            $sql = $this->prepare();
        }

        $result = $this->adapter->exec($sql);


        if (false === $result) {
            throw new DbException($sql . $this->adapter->getErrorMessage());
        }

        return $result;
    }

    /**
     * @return string
     */
    public function prepare()
    {

        $array = [];

        foreach ($this->_data as $key => $value) {
            $array [] = $key . '=' . $this->adapter->quoteValue($value);
        }

        $where = empty($this->_where) ? ''
            : ' WHERE ' . $this->_where->prepare();

        return 'UPDATE ' . $this->_tableName . ' SET ' . implode(', ', $array)
        . $where;
    }
}