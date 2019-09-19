<?php


namespace Art4es\Tests;


use Art4es\exceptions\file\FileNotFoundException;
use Art4es\exceptions\file\FileNotOpenedException;
use Art4es\file\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public $baseFilePath = __DIR__ . '/../test_files/';

    public function testSetupFilePath()
    {
        $filePath = $this->baseFilePath . '/notExistedFile.txt';
        $file = new File($filePath);
        $this->assertEquals($filePath, $file->getPath());
    }

    public function testNotExistedFile()
    {
        $filePath = $this->baseFilePath . 'notExistedFile.txt';
        $file = new File($filePath);
        $this->expectException(FileNotFoundException::class);
        $file->open();
        $file->close();
    }

    public function testOpenFile()
    {
        $filePath1 = $this->baseFilePath . '/test1.txt';
        $filePath3 = $this->baseFilePath . '/test2.txt';
        $file = new File($filePath1);
        $fileStream = $file->open();
        $fileContent1 = '';
        while (($line = fgetc($fileStream)) !== false) {
            $fileContent1 .= $line;
        }
        $file->close();

        /** read file in vanila =) */
        $fileStream = fopen($filePath1, 'r');
        $fileContent2 = '';
        while (($line = fgetc($fileStream)) !== false) {
            $fileContent2 .= $line;
        }
        fclose($fileStream);

        /** read another file */
        $fileStream = fopen($filePath3, 'r');
        $fileContent3 = '';
        while (($line = fgetc($fileStream)) !== false) {
            $fileContent3 .= $line;
        }
        fclose($fileStream);

        $this->assertEquals($fileContent1, $fileContent2);
        $this->assertNotEquals($fileContent1, $fileContent3);
        $this->assertNotEquals($fileContent2, $fileContent3);
    }

    public function testCloseNotOpenedFile()
    {
        $filePath = $this->baseFilePath . '/test1.txt';
        $file = new File($filePath);
        $this->expectException(FileNotOpenedException::class);
        $file->close();
    }
}