<?php

namespace Service\Log;

use Throwable;

class LogFileService implements LogInterface
{
    private string $logFile;

    public function __construct($logFile) {
        $this->logFile = $logFile;
    }

    public function log(Throwable $exception) : void
    {
        $currentTime = date('Y-m-d H:i:s');
        $message = "Ошибка: " . $exception->getMessage() .
                    "\nФайл: " . $exception->getFile() .
                    "\nСтрока: " . $exception->getLine() .
                    "\nВремя: ". $currentTime.
            "\n";

        error_log($message, 3, $this->logFile);
    }
}
