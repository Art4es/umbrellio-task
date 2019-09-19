<?php


namespace Art4es\Tests\config;


use Art4es\config\YamlValidatorsProvider;
use Art4es\exceptions\validator\FileDoesNotExistsException;
use PHPUnit\Framework\TestCase;

class YamlValidatorsParserTest extends TestCase
{
    public $fileBasePath = __DIR__ . '/../test_files';

    public function testConfigFileNotFound()
    {
        $filePath = $this->fileBasePath . '/notExistingName.yaml';
        $this->expectException(FileDoesNotExistsException::class);
        $yamlParser = new YamlValidatorsProvider($filePath);
    }

    public function testParsingFileContent()
    {
        $filePath = $this->fileBasePath . '/config.yaml';
        $yamlParser = new YamlValidatorsProvider($filePath);
        $result = $yamlParser->parseFileContent();
        $expected = [
            'mime_types' => [
                'text/plain',
                'application/json'
            ],
            'extension' => [
                'bmp',
                'jpeg'
            ],
            'file_size' =>
                [
                    'min' => 10,
                    'max' => 60
                ]
        ];
        $this->assertEquals($expected, $result);
        $this->assertNotEquals([], $result);
    }

}
