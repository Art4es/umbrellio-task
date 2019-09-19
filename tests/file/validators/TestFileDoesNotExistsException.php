<?php


namespace Art4es\Tests\file\validators;


use Art4es\exceptions\validator\FileDoesNotExistsException;
use Art4es\file\File;
use Art4es\file\validators\FileExistingValidator;
use PHPUnit\Framework\TestCase;

class TestFileDoesNotExistsException extends TestCase
{
    public function testThrowingException()
    {
        $validator = new FileExistingValidator();
        $filePath = __DIR__ . '/../../test_files/test10.txt';
        $this->expectException(FileDoesNotExistsException::class);
        $validator->validate(new File($filePath));
    }

    public function testValidation()
    {
        $validator = new FileExistingValidator();
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->assertTrue($validator->validate(new File($filePath)));
    }
}