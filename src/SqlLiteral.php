<?php

namespace Phpfox\Db;


class SqlLiteral
{
    /**
     * @var string
     */
    protected $literal = '';

    /**
     * SqlLiteral constructor.
     *
     * @param $literal
     */
    public function __construct($literal)
    {

    }

    /**
     * @return string
     */
    public function getLiteral()
    {
        return $this->literal;
    }

    /**
     * @param string $literal
     */
    public function setLiteral($literal)
    {
        $this->literal = $literal;
    }
}