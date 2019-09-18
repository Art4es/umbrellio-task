<?php


namespace Art4es\Tests;


use Art4es\exceptions\FileNotFoundException;
use Art4es\exceptions\FileNotOpenedException;
use Art4es\file\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testSetupFilePath()
    {
        $filePath = __DIR__ . '/files/notExistedFile.txt';
        $file = new File($filePath);
        $this->assertEquals($filePath, $file->getPath());
    }

    public function testNotExistedFile()
    {
        $filePath = __DIR__ . '/files/notExistedFile.txt';
        $file = new File($filePath);
        $this->expectException(FileNotFoundException::class);
        $file->open();
        $file->close();
    }

    public function testOpenFile()
    {
        $filePath1 = __DIR__ . '/files/test1.txt';
        $filePath3 = __DIR__ . '/files/test2.txt';
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
        $filePath = __DIR__ . '/files/test1.txt';
        $file = new File($filePath);
        $this->expectException(FileNotOpenedException::class);
        $file->close();
    }
}