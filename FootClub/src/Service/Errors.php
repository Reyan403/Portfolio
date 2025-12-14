<?php

namespace Service;

Class Errors 
{
    protected array $errors;

    public function __construct (array $errors = [])
    {
        $this->errors = $errors;
    }

    public function getErrors() : array 
    {
        return $this->errors;
    }
}