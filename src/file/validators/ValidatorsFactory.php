<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\UndefinedValidatorException;

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

    public static function getAvailableValidators()
    {
        return self::$availableValidators;
    }

    public static function addToAvailableValidators(array $validator)
    {
        foreach ($validator as $validatorConfigName => $validatorClassName) {
            self::$availableValidators[$validatorConfigName] = $validatorClassName;
        }
    }
}