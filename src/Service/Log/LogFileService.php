<?php

namespace Service\Log;

use Throwable;

class LogFileService implements LogInterface
{
    public function log(Throwable $exception) : void
    {
        $currentTime = date('Y-m-d H:i:s');
        $fileName = "../Storage/errors.txt";
        $message = "\nВремя: ". $currentTime.
                    "\nОшибка: " . $exception->getMessage() .
                    "\nФайл: " . $exception->getFile() .
                    "\nСтрока: " . $exception->getLine() .
                    "\n";

        file_put_contents($fileName, $message, FILE_APPEND);
    }
}
