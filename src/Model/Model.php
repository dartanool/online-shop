<?php
namespace Model;
use PDO;

abstract class Model
{
    protected static  PDO $PDO;

    public static function getPDO() : PDO
    {
        static::$PDO = new PDO ('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        return static::$PDO;
    }

    abstract static protected function getTableName(): string;
}