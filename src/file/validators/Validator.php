<?php


namespace Art4es\file\validators;


abstract class Validator implements IValidator
{
    public final function __construct(array $params = [])
    {
        $this->configure($params);
    }

    abstract protected function configure(array $params = []): void;
}