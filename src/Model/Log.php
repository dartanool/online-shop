<?php

namespace Model;

class Log extends Model
{

    public function create(string $message, string $file, string $line) : void
    {
        $statement = $this->pdo->prepare("
                        INSERT INTO {$this->getTableName()}(message, file, line)
                        VALUES (:message, :file, :line)"
        );
        $statement->execute(['message' => $message,
                            'file' => $file,
                            'line' => $line]);
    }

    protected function getTableName(): string
    {
        return 'logs';
    }
}