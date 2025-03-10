<?php

namespace Request;

abstract class BaseRequest
{
    public function __construct(private array $data)
    {

    }
}