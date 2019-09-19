<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\ValidatorException;
use Art4es\file\IFile;

interface IValidator
{
    /**
     * @param IFile $file
     * @return bool
     * @throws ValidatorException
     */
    public function validate(IFile $file): bool;
}