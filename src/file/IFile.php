<?php


namespace Art4es\file;


use Art4es\exceptions\file\FileNotFoundException;

interface IFile
{

    public function getPath(): string;

    /**
     * @param string $mode
     * @return resource
     * @throws FileNotFoundException
     */
    public function open(string $mode = 'r');

    public function close(): bool;
}