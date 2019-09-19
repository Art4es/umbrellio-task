<?php


namespace Art4es\config;


class YamlValidatorsProvider extends FileValidatorsProvider
{
    public function parseFileContent(): array
    {
        return yaml_parse_file($this->filePath);
    }
}