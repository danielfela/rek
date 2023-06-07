<?php

namespace Models;

class Model implements \Iterator
{
//C88AEDZqmDPO1wEOekS9
    protected \PDO $connection;
    protected string $table;
    protected \PDOStatement $statement;

    protected ?Model $current = null;
    public function __construct()
    {
        global $dbh;
        $this->connection = $dbh;
        $this->table = strtolower(get_class($this));
    }

    public function exec(array|null $columns = null): bool
    {

        if(null === $columns) {
            $columns = '*';
        }
        else {
            $columns = implode(',', $columns);
        }

        $this->statement =  $this->connection->prepare(
            'SELECT '.$columns.' FROM '.$this->table
        );

        $this->statement->setFetchMode(
            \PDO::FETCH_CLASS,
            '\Models\\'.ucfirst($this->table)
            );

        $this->statement->execute();
        $this->next();

        return $this->valid();
    }

    public function getBy($name, $value, $columns = null){
        if(null === $columns) {
            $columns = '*';
        }
        else {
            $columns = implode(',', $columns);
        }

        $this->statement =  $this->connection->prepare(
            'SELECT '.$columns.' FROM '.$this->table.' WHERE `'.$name.'` = ? LIMIT 1'
        );
        $this->statement->setFetchMode(
            \PDO::FETCH_CLASS,
            '\Models\\'.ucfirst($this->table)
        );

        $this->statement->bindValue(1, $value);
        $this->statement->execute();

        return $this->statement->fetch();
    }

    #[\ReturnTypeWillChange]
    public function current(): mixed
    {
        return $this->current;
    }

    public function next(): void
    {
        $rec = $this->statement->fetch(\PDO::FETCH_CLASS);
        $this->current = $rec ?: null;
    }

    public function key(): mixed
    {
        return 0;
    }

    public function valid(): bool
    {
        return !!$this->current;
    }

    public function rewind(): void{
        return;
    }

    public function __get($name) {
        $method = 'get'.ucfirst($name);

        if(method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }

    public function create($table){
        include_once ucfirst($table).'.php';
        $class = '\Models\\'.ucfirst($table);
        $instance = new $class();
        $instance->table = $table;
        return $instance;
    }
}
