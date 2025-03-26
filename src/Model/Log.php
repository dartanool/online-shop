<?php

namespace Model;

class Log extends Model
{

    public static function create(string $message, string $file, string $line) : void
    {
        $tableName = static ::getTableName();
        $statement = static::getPDO()->prepare("
                        INSERT INTO $tableName (message, file, line)
                        VALUES (:message, :file, :line)"
        );
        $statement->execute(['message' => $message,
                            'file' => $file,
                            'line' => $line]);
    }

    protected static function getTableName(): string
    {
        return 'logs';
    }
}