<?php

namespace Phpfox\Db;

/**
 * Class Collection
 *
 * @package Phpfox\Db
 */
class Collection implements \ArrayAccess, \Countable, \SeekableIterator
{
    /**
     * @var Model[]
     */
    protected $items = [];

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return array_key_exists($this->items, $offset);
    }

    /**
     * @param mixed $offset
     *
     * @return \Phpfox\Db\Model
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @return \Phpfox\Db\Model|null
     */
    public function current()
    {
        if ($this->valid() === false) {
            return false;
        }

        return $this->items[$this->position];
    }

    /**
     *
     */
    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     *
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @param int $position
     *
     * @return Collection
     */
    public function seek($position)
    {
        $position = (int)$position;
        if ($position < 0 || $position >= count($this->items)) {
        }
        $this->position = $position;

        return $this;
    }

    /**
     * @param $item
     */
    public function push($item)
    {
        $this->items[] = $item;
    }

    /**
     * delete all items
     */
    public function delete()
    {
        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    /**
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function map(\Closure $callback)
    {
        return array_map($callback, $this->items);
    }

    /**
     * @return \Phpfox\Db\Model[]
     */
    public function toArray()
    {
        return $this->items;
    }

    public function reserve()
    {
        array_reverse($this->items);

        return $this;
    }
}