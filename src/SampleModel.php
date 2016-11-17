<?php

namespace Phpfox\Db;


class SampleModel implements ModelInterface
{
    /**
     * @var bool
     */
    private $saved = false;

    /**
     * @var array
     */
    private $data = [];

    public function isSaved()
    {
        return $this->saved;
    }

    public function toArray()
    {
        return [];
    }

    public function exchangeArray($array)
    {
        $this->data = $array;
        return $this;
    }

    public function delete()
    {
        gateways($this->shortcut())->delete();
    }

    public function save()
    {
        gateways($this->shortcut())->save();
    }
}