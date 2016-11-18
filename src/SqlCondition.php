<?php

namespace Phpfox\Db;

/**
 * Class SqlCondition
 *
 * @package Phpfox\Db
 */
class SqlCondition
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * SqlCondition constructor.
     *
     * @param $adapter
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param      $expression
     * @param null $value
     *
     * @return $this
     */
    public function where($expression, $value = null)
    {
        $this->_where(' AND ', $expression, $value);

        return $this;
    }

    /**
     * @param      $type
     * @param      $expression
     * @param null $value
     *
     * @return $this
     */
    protected function _where($type, $expression, $value = null)
    {
        $str = null;

        if (is_null($value)) {
            $str = str_replace('?', 'NULL', $expression);
        } else {
            if (is_array($value)) {
                $str = strtr($expression, $this->quoteArray($value));
            } else {
                if ($value instanceof SqlLiteral) {
                    $str = $value->getLiteral();
                } else {
                    $str = str_replace('?', $this->adapter->quoteValue($value),
                        $expression);
                }
            }
        }

        $this->elements [] = [$type, $str];

        return $this;
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function quoteArray(array $values)
    {
        $result = [];

        // check first key

        if (is_numeric(array_keys($values)[0])) {
            foreach ($values as $k => $v) {
                $result[$k] = $this->adapter->quoteValue($v);
            }

            return ['?' => '(' . implode(', ', $result) . ')'];
        } else {
            foreach ($values as $k => $v) {
                $result[$k] = $this->adapter->quoteValue($v);
            }
        }

        return $result;

    }

    /**
     * @param $expression
     * @param $value
     *
     * @return SqlCondition
     */
    public function orWhere($expression, $value)
    {
        return $this->_where(' OR ', $expression, $value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->prepare();
    }

    /**
     * @return string
     */
    public function prepare()
    {

        $result = '';

        foreach ($this->elements as $item) {
            list($type, $express) = $item;

            if ($result == '') {
                $result = ' (' . $express . ') ';
            } else {
                $result .= $type . ' (' . $express . ') ';
            }
        }

        if ('' == $result) {
            $result = ' 1 ';
        }

        return $result;
    }
}