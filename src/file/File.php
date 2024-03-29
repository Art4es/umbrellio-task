<?php


namespace Art4es\file;


use Art4es\exceptions\file\FileNotFoundException;
use Art4es\exceptions\file\FileNotOpenedException;

class File implements IFile
{
    private $path;
    private $resource;

    public function __construct($filePath)
    {
        $this->path = $filePath;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function open(string $mode = 'r')
    {
        try {
            if (empty($this->resource)) {
                $this->resource = fopen($this->path, $mode);
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