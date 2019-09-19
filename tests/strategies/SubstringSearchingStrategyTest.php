<?php


namespace Art4es\Tests;


use Art4es\file\File;
use Art4es\strategies\SubstringSearchingStrategy;
use PHPUnit\Framework\TestCase;

class SubstringSearchingStrategyTest extends TestCase
{
    public $baseFilePath = __DIR__ . '/../test_files/';

    public function testSearchMultipleResults()
    {
        $filePath = $this->baseFilePath . '/test1.txt';
        $file = new File($filePath);
        $strategy = new SubstringSearchingStrategy('first');
        $result = $strategy->search($file);
        $expected = [
            ['line' => 1, 'position' => 0],
            ['line' => 2, 'position' => 11],
            ['line' => 3, 'position' => 5]
        ];
        $this->assertEquals($expected, $result);
    }

    public function testSearchSingleResult()
    {
        $filePath = $this->baseFilePath . '/test2.txt';
        $file = new File($filePath);
        $strategy1 = new SubstringSearchingStrategy('3');
        $result1 = $strategy1->search($file);
        $strategy2 = new SubstringSearchingStrategy('2');
        $result2 = $strategy2->search($file);
        $this->assertEquals([['line' => 2, 'position' => 0]], $result1);
        $this->assertEquals([['line' => 1, 'position' => 2]], $result2);
    }

    public function testMultipleMatchesInOneLine()
    {
        $filePath = $this->baseFilePath . '/test3.txt';
        $file = new File($filePath);
        $strategy = new SubstringSearchingStrategy('a');
        $result = $strategy->search($file);
        $expected = [
            ['line' => 1, 'position' => 9],
            ['line' => 2, 'position' => 0],
            ['line' => 2, 'position' => 1],
            ['line' => 2, 'position' => 2],
            ['line' => 4, 'position' => 0],
            ['line' => 4, 'position' => 5],
            ['line' => 4, 'position' => 9]
        ];
        $this->assertEquals($expected, $result);
    }

    public function testChangingNeedle()
    {

        $filePath = $this->baseFilePath . '/test1.txt';
        $file = new File($filePath);
        $strategy = new SubstringSearchingStrategy('first');
        $result1 = $strategy->search($file);
        $expected1 = [
            ['line' => 1, 'position' => 0],
            ['line' => 2, 'position' => 11],
            ['line' => 3, 'position' => 5]
        ];
        $this->assertEquals($expected1, $result1);

        $strategy->changeNeedleTo('second');
        $result2 = $strategy->search($file);
        $expected2 = [
            ['line' => 1, 'position' => 5],
            ['line' => 2, 'position' => 0],
            ['line' => 3, 'position' => 10]
        ];
        $this->assertEquals($expected2, $result2);
    }
}