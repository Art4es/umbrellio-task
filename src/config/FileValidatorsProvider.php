<?php


namespace Art4es\config;


use Art4es\exceptions\validator\UndefinedValidatorException;
use Art4es\file\File;
use Art4es\file\validators\FileExistingValidator;
use Art4es\file\validators\IValidator;
use Art4es\file\validators\ValidatorsFactory;

abstract class FileValidatorsProvider implements IValidatorsProvider
{

    protected $filePath;

    public function __construct(string $filePath)
    {
        (new FileExistingValidator())->validate(new File($filePath));
        $this->filePath = $filePath;
    }

    /**
     * @return IValidator[]
     * @throws UndefinedValidatorException
     */
    public final function getValidators(): array
    {
        return ValidatorsFactory::parseValidatorsConfig($this->parseFileContent());
    }

    abstract public function parseFileContent(): array;
}