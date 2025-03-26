<?php

namespace Service\Log;

use Model\Log;
use Throwable;

class LogDbService implements LogInterface
{
    public function log(Throwable $exception) : void
    {
        Log::create($exception->getMessage(),
                                $exception->getFile(),
                                $exception->getLine());
    }

}