<?php


namespace Art4es\Tests;


use Art4es\exceptions\FileNotFoundException;
use Art4es\exceptions\FileNotOpenedException;
use Art4es\file\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
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
        $filePath = __DIR__ . '/files/test1.txt';
        $file = new File($filePath);
        $fileContent = $file->open();
        $fileContent2 = fopen($filePath, 'r');
        $firstFile = '';
        $secondFile = '';
        while (($line1 = fgetc($fileContent)) === true || ($line2 = fgetc($fileContent2)) === true) {
            $firstFile .= $line1;
            $secondFile .= $line2;
        }
        $this->assertEquals($firstFile, $secondFile);
        $file->close();
        fclose($fileContent2);
    }

    public function testCloseNotOpenedFile()
    {
        $filePath = __DIR__ . '/files/test1.txt';
        $file = new File($filePath);
        $this->expectException(FileNotOpenedException::class);
        $file->close();
    }
}