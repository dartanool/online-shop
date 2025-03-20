<?php

namespace Service\Log;

use Model\Log;
use Throwable;

class LogDbService implements LogInterface
{
    private Log $logModel;
    public function __construct()
    {
        $this->logModel = new Log();
    }
    public function log(Throwable $exception) : void
    {
        $this->logModel->create($exception->getMessage(),
                                $exception->getFile(),
                                $exception->getLine());
    }

}