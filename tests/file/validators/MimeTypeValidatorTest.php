<?php


namespace Art4es\Tests\file\validators;


use Art4es\exceptions\validator\MimeTypeDoesNotSupportException;
use Art4es\file\File;
use Art4es\file\validators\MimeTypeValidator;
use PHPUnit\Framework\TestCase;

class MimeTypeValidatorTest extends TestCase
{
    public function testThrowingException()
    {
        $validator = new MimeTypeValidator(['application/json']);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->expectException(MimeTypeDoesNotSupportException::class);
        $validator->validate(new File($filePath));
    }

    public function testValidation()
    {
        $validator = new MimeTypeValidator(['application/json', 'text/plain']);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->assertTrue($validator->validate(new File($filePath)));
    }
}