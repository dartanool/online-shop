<?php

namespace Service\Log;

use Throwable;

interface LogInterface
{
    public function log(Throwable $exception) : void;
}