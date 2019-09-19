<?php


namespace Art4es\config;


use Art4es\file\validators\IValidator;

interface IConfigParser
{

    /**
     * @return IValidator[]
     */
    public function getValidators(): array;
}