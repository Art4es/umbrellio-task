<?php


namespace Art4es\Tests\files;


use Art4es\config\YamlValidatorsProvider;
use Art4es\exceptions\validator\ExtensionDoesNotSupportException;
use Art4es\exceptions\validator\FileDoesNotExistsException;
use Art4es\exceptions\validator\IncorrectFileSizeException;
use Art4es\exceptions\validator\MimeTypeDoesNotSupportException;
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

    public function testFinderWithValidatorsNoErrors()
    {
        $yamlConfigPath = __DIR__ . '/test_files/final_config.yaml';
        $file = new File(__DIR__ . '/test_files/test2.txt');
        $strategy = new SubstringSearchingStrategy('7');
        $validatorsProvider = new YamlValidatorsProvider($yamlConfigPath);
        $finder = new Finder($file, $strategy, $validatorsProvider);
        $result = $finder->execute();
        $expected = [
            ['line' => 3, 'position' => 1]
        ];
        $this->assertEquals($expected, $result);
    }

    public function testFinderWithFailMimeValidator()
    {
        $yamlConfigPath = __DIR__ . '/test_files/final_config_wrong_mime.yaml';
        $file = new File(__DIR__ . '/test_files/test2.txt');
        $strategy = new SubstringSearchingStrategy('7');
        $validatorsProvider = new YamlValidatorsProvider($yamlConfigPath);
        $finder = new Finder($file, $strategy, $validatorsProvider);
        $this->expectException(MimeTypeDoesNotSupportException::class);
        $result = $finder->execute();
    }

    public function testFinderWithFailExtensionValidator()
    {
        $yamlConfigPath = __DIR__ . '/test_files/final_config_wrong_extension.yaml';
        $file = new File(__DIR__ . '/test_files/test2.txt');
        $strategy = new SubstringSearchingStrategy('7');
        $validatorsProvider = new YamlValidatorsProvider($yamlConfigPath);
        $finder = new Finder($file, $strategy, $validatorsProvider);
        $this->expectException(ExtensionDoesNotSupportException::class);
        $result = $finder->execute();
    }

    public function testFinderWithFailFileSizeValidator()
    {
        $yamlConfigPath = __DIR__ . '/test_files/final_config_wrong_file_size.yaml';
        $file = new File(__DIR__ . '/test_files/test2.txt');
        $strategy = new SubstringSearchingStrategy('7');
        $validatorsProvider = new YamlValidatorsProvider($yamlConfigPath);
        $finder = new Finder($file, $strategy, $validatorsProvider);
        $this->expectException(IncorrectFileSizeException::class);
        $result = $finder->execute();
    }

}