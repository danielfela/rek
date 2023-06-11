<?php

namespace Model;

class Model extends \Phalcon\Mvc\Model
{
    protected \PDO $connection;
    protected string $table;
    protected \PDOStatement $statement;
    protected ?Model $current = null;
}
