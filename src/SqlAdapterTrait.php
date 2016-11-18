<?php
namespace Phpfox\Db;


Trait SqlAdapterTrait
{
    public function insert($table, $data)
    {
        return (new SqlInsert($this))->insert($table, $data);
    }

    public function select()
    {
        return new SqlSelect($this);
    }

    public function update($table, $data)
    {
        return (new SqlUpdate($this))->update($table, $data);
    }

    public function delete($table)
    {
        return (new SqlDelete($this))->from($table);
    }

    public function insertDelay($table, $data)
    {
        return (new SqlInsert($this))->insert($table, $data)->setDelay(true);
    }
}