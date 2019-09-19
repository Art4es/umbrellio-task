<?php


namespace Art4es\Tests\file\validators;


use Art4es\exceptions\validator\IncorrectFileSizeException;
use Art4es\file\File;
use Art4es\file\validators\FileSizeValidator;
use PHPUnit\Framework\TestCase;

class FileSizeValidatorTest extends TestCase
{
    public function testFileSizeValidatorMin()
    {
        $validator = new FileSizeValidator([FileSizeValidator::MIN => 60]);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->expectException(IncorrectFileSizeException::class);
        $validator->validate(new File($filePath));
    }

    public function testFileSizeValidatorMax()
    {
        $validator = new FileSizeValidator([FileSizeValidator::MAX => 10]);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->expectException(IncorrectFileSizeException::class);
        $validator->validate(new File($filePath));
    }

    public function testValidation()
    {
        $validator = new FileSizeValidator([FileSizeValidator::MIN => 10, FileSizeValidator::MAX => 60]);
        $filePath = __DIR__ . '/../../test_files/test1.txt';
        $this->assertTrue($validator->validate(new File($filePath)));
    }
}