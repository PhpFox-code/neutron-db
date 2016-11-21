<?php

namespace Phpfox\Db;


use Phpfox\Model\GatewayInterface;

class TableGateway implements GatewayInterface
{
    /**
     * @var string
     */
    protected $identity = '';

    /**
     * @var array
     */
    protected $column = [];

    /**
     * @var null
     */
    protected $driver = null;

    /**
     * @var array
     */
    protected $primary = [];

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var string
     */
    protected $modelClass = 'StdClass';

    /**
     * @var string
     */
    protected $adapter = 'db';

    /**
     * @var array
     */
    protected $defaultValue = [];

    public function __construct(
        $collection,
        $modelClass,
        $gatewayId,
        $adapter
    ) {
        if (substr($collection, 0, 1) == ':') {
            $collection = PHPFOX_TABLE_PREFIX . substr($collection, 1);
        }

        if (null != $adapter) {
            $adapter = 'db';
        }

        $this->modelClass = $modelClass;
        $this->adapter = $adapter;
        $this->table = $collection;
    }

    /**
     * @return string|false
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function insert($data)
    {
        return (new SqlInsert($this->_adapter()))->insert($this->getTable(),
            array_intersect_key($data, $this->getColumn()))->execute();
    }

    /**
     * @return AdapterInterface
     */
    public function _adapter()
    {
        return service('db');
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function insertIgnore($data)
    {
        $sql = (new SqlInsert($this->_adapter()))->insert($this->getTable(),
            array_intersect_key($data, $this->getColumn()))
            ->ignoreOnDuplicate(true);

        return $sql->execute();
    }

    /**
     * @return array
     */
    public function getDefault()
    {
        return $this->defaultValue;
    }

    /**
     * @param  array $data
     *
     * @return array (expression, condition)
     */
    public function getCondition($data)
    {

        $primaryData = array_intersect_key($data, $this->getPrimary());

        $expressionArray = [];
        $condition = [];

        foreach ($primaryData as $k => $v) {
            $expressionArray [] = "$k=:$k ";
            $condition [":$k"] = $v;
        }

        $expression = implode(' AND ', $expressionArray);

        return [$expression, $condition];
    }

    /**
     * @return array
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param array $data
     * @param array $values
     *
     * @return mixed
     */
    public function updateModel($data, $values = null)
    {
        if (empty($values)) {
            $values = $data;
        }

        $values = array_intersect_key($values, $this->getColumnNotPrimary());

        if (empty($values)) {
            return true;
        }

        $query = new SqlUpdate($this->_adapter());

        $query->update($this->getTable())->values($values);

        foreach ($this->getPrimary() as $column => $type) {
            $query->where("$column=?", $data[$column]);
        }

        return $query->execute();
    }

    /**
     * @return array
     */
    public function getColumnNotPrimary()
    {
        return array_diff_key($this->column, $this->primary);
    }

    /**
     * @param array $values
     *
     * @return SqlUpdate
     */
    public function update($values)
    {
        return (new SqlUpdate($this->_adapter()))->update($this->getTable())
            ->values($values);
    }

    /**
     * @param  array|null $data
     *
     * @return mixed
     */
    public function create($data = null)
    {
        return (new ($this->modelClass)($data, false));
    }

    /**
     * @param string $alias
     *
     * @return SqlSelect
     */
    public function select($alias = null)
    {
        if (null == $alias) {
            $alias = 't1';
        }

        return (new SqlSelect($this->_adapter()))->setModel($this->modelClass)
            ->from($this->getTable(), $alias);
    }

    /**
     * @return SqlDelete
     */
    public function delete()
    {
        return (new SqlDelete($this->_adapter()))->from($this->getTable());
    }

    public function findById($id)
    {
        throw new \Exception("Can not use '{$this->table}' using findById()");
    }
}