<?php


namespace Art4es\Tests\file\validators;


use Art4es\config\YamlValidatorsProvider;
use Art4es\exceptions\validator\UndefinedValidatorException;
use Art4es\file\validators\ExtensionValidator;
use Art4es\file\validators\FileExistingValidator;
use Art4es\file\validators\FileSizeValidator;
use Art4es\file\validators\MimeTypeValidator;
use Art4es\file\validators\ValidatorsFactory;
use PHPUnit\Framework\TestCase;

class ValidatorsFactoryTest extends TestCase
{

    public $baseFilePath = __DIR__ . '/../../test_files/';

    public function testAddingNewValidator()
    {
        $newValidator = ['new_validator' => 'path/to/validator/NewValidator'];
        $this->assertFalse(array_key_exists('new_validator', ValidatorsFactory::getAvailableValidators()));
        $this->assertFalse(in_array('path/to/validator/NewValidator', ValidatorsFactory::getAvailableValidators()));

        ValidatorsFactory::addToAvailableValidators($newValidator);
        $this->assertTrue(array_key_exists('new_validator', ValidatorsFactory::getAvailableValidators()));
        $this->assertTrue(in_array('path/to/validator/NewValidator', ValidatorsFactory::getAvailableValidators()));
    }

    public function testCreateMimeTypeValidator()
    {
        $parser = new YamlValidatorsProvider($this->baseFilePath . 'mime_type_config.yaml');
        $validators = $parser->getValidators();
        $mimeValidator = reset($validators);
        $this->assertInstanceOf(MimeTypeValidator::class, $mimeValidator);
        $this->assertNotInstanceOf(ExtensionValidator::class, $mimeValidator);
        $this->assertNotInstanceOf(FileExistingValidator::class, $mimeValidator);
        $this->assertNotInstanceOf(FileSizeValidator::class, $mimeValidator);

        /** @var $extensionValidator MimeTypeValidator */
        $this->assertEquals(['text/plain', 'application/json'], $mimeValidator->getMimeTypes());
    }

    public function testCreateExtensionValidator()
    {
        $parser = new YamlValidatorsProvider($this->baseFilePath . 'extension_config.yaml');
        $validators = $parser->getValidators();
        $extensionValidator = reset($validators);
        $this->assertInstanceOf(ExtensionValidator::class, $extensionValidator);
        $this->assertNotInstanceOf(MimeTypeValidator::class, $extensionValidator);
        $this->assertNotInstanceOf(FileExistingValidator::class, $extensionValidator);
        $this->assertNotInstanceOf(FileSizeValidator::class, $extensionValidator);

        /** @var $extensionValidator ExtensionValidator */
        $this->assertEquals(['bmp', 'jpeg'], $extensionValidator->getExtensions());
    }

    public function testCreateFileSizeValidator()
    {
        $parser = new YamlValidatorsProvider($this->baseFilePath . 'file_size_config.yaml');
        $validators = $parser->getValidators();
        $fileSizeValidator = reset($validators);
        $this->assertInstanceOf(FileSizeValidator::class, $fileSizeValidator);
        $this->assertNotInstanceOf(MimeTypeValidator::class, $fileSizeValidator);
        $this->assertNotInstanceOf(FileExistingValidator::class, $fileSizeValidator);
        $this->assertNotInstanceOf(ExtensionValidator::class, $fileSizeValidator);

        /** @var $extensionValidator FileSizeValidator */
        $this->assertEquals(10, $fileSizeValidator->getMinSize());
        $this->assertEquals(60, $fileSizeValidator->getMaxSize());
    }

    public function testCreateUndefinedValidator()
    {
        $parser = new YamlValidatorsProvider($this->baseFilePath . 'undefined_config.yaml');
        $this->expectException(UndefinedValidatorException::class);
        $parser->getValidators();
    }

    public function testCreateMultipleValidators()
    {
        $parser = new YamlValidatorsProvider($this->baseFilePath . 'config.yaml');
        $validators = $parser->getValidators();
        $mimeValidatorsAmount = 0;
        $extensionValidatorsAmount = 0;
        $fileSizeValidatorsAmount = 0;
        foreach ($validators as $validator) {
            if ($validator instanceof MimeTypeValidator) {
                $mimeValidatorsAmount++;
            }
            if ($validator instanceof ExtensionValidator) {
                $extensionValidatorsAmount++;
            }
            if ($validator instanceof FileSizeValidator) {
                $fileSizeValidatorsAmount++;
            }
        }

        $this->assertEquals(1, $mimeValidatorsAmount);
        $this->assertEquals(1, $extensionValidatorsAmount);
        $this->assertEquals(1, $fileSizeValidatorsAmount);

    }

}