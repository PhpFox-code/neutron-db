<?php

namespace Phpfox\Db;

/**
 * Interface ModelInterface
 *
 * @package Phpfox\Db
 */
interface ModelInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * Update data from array
     *
     * @param $array
     *
     * @return $this
     */
    public function exchangeArray($array);

    /**
     * @return bool
     * @throws SqlException
     */
    public function delete();

    /**
     * @return $this
     * @throws SqlException
     */
    public function save();

    /**
     * @return bool
     */
    public function isSaved();

    /**
     * @return string
     */
    public function shortcut();
}