<?php


namespace Art4es\file;


use Art4es\exceptions\FileNotFoundException;

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
        if (empty($this->resource)) {
            $this->resource = fopen($this->filePath, $mode);
            if (!$this->resource) {
                throw new FileNotFoundException();
            }
        }
        return $this->resource;
    }

    public function close(): bool
    {
        if (!empty($this->resource)) {
            fclose($this->resource);
            $this->resource = null;
        }
    }
}