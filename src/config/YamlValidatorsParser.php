<?php


namespace Art4es\config;


class YamlValidatorsParser extends FileValidatorsParser
{
    public function parseFileContent(): array
    {
        return yaml_parse($this->filePath);
    }
}