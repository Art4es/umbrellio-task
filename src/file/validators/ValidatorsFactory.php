<?php


namespace Art4es\config;


use Art4es\exceptions\validator\UndefinedValidatorException;
use Art4es\file\validators\ExtensionValidator;
use Art4es\file\validators\FileSizeValidator;
use Art4es\file\validators\IValidator;
use Art4es\file\validators\MimeTypeValidator;

class ValidatorsFactory
{
    private const MIME_TYPES = 'mime_types';
    private const EXTENSIONS = 'extension';
    private const FILE_SIZE = 'file_size';

    private static $availableValidators = [
        self::MIME_TYPES => MimeTypeValidator::class,
        self::EXTENSIONS => ExtensionValidator::class,
        self::FILE_SIZE => FileSizeValidator::class,
    ];
    private static $validators = [];

    /**
     * @param array $validatorsConfig
     * @return IValidator[]
     * @throws UndefinedValidatorException
     */
    public static function parseValidatorsConfig(array $validatorsConfig = []): array
    {
        self::$validators = [];
        foreach ($validatorsConfig as $validatorConst => $validatorParams) {
            if (!isset(self::$availableValidators[$validatorConst])) {
                throw new UndefinedValidatorException();
            }
            $validatorClass = self::$availableValidators[$validatorConst];
            self::$validators[$validatorClass] = new $validatorClass($validatorParams);
        }
        return self::$validators;
    }
}