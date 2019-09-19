<?php


namespace Art4es\Tests\file\validators;


use Art4es\exceptions\validator\ExtensionDoesNotSupportException;
use Art4es\file\File;
use Art4es\file\validators\ExtensionValidator;
use PHPUnit\Framework\TestCase;

class ExtensionValidatorTest extends TestCase
{
    public function testThrowingException()
    {
        $validator = new ExtensionValidator(['bmp']);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->expectException(ExtensionDoesNotSupportException::class);
        $validator->validate(new File($filePath));
    }

    public function testValidation()
    {
        $validator = new ExtensionValidator(['bmp', 'txt']);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->assertTrue($validator->validate(new File($filePath)));
    }
}