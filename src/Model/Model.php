<?php
namespace Model;
abstract class Model
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo =  new \PDO ('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
    }

    abstract protected function getTableName(): string;
}