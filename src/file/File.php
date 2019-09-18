<?php


namespace Art4es\file;


use Art4es\exceptions\FileNotFoundException;
use Art4es\exceptions\FileNotOpenedException;

class File implements IFile
{
    private $filePath = '';
    private $resource;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function open(string $mode = 'r')
    {
        try {
            if (empty($this->resource)) {
                $this->resource = fopen($this->filePath, $mode);
            }
        } catch (\Throwable $e) {
            throw new FileNotFoundException();
        }

        return $this->resource;
    }

    public function close(): bool
    {
        if (empty($this->resource)) {
            throw new FileNotOpenedException();
        }

        $result = fclose($this->resource);
        $this->resource = null;
        return $result;

    }
}