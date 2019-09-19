<?php


namespace Art4es\Tests\files;


use Art4es\exceptions\validator\FileDoesNotExistsException;
use Art4es\file\File;
use Art4es\Finder;
use Art4es\strategies\SubstringSearchingStrategy;
use PHPUnit\Framework\TestCase;

class FinderTest extends TestCase
{
    public function testFileExistingValidator()
    {
        $file = new File('notExistedFile');
        $strategy = new SubstringSearchingStrategy('empty');
        $finder = new Finder($file, $strategy);
        $this->expectException(FileDoesNotExistsException::class);
        $finder->execute();
    }

    public function testValidatorDoesNotBreakCommonBehavior()
    {
        $file = new File(__DIR__ . '/test_files/test2.txt');
        $strategy = new SubstringSearchingStrategy('7');
        $finder = new Finder($file, $strategy);
        $result = $finder->execute();
        $expected = [
            ['line' => 3, 'position' => 1]
        ];
        $this->assertEquals($expected, $result);
    }
}