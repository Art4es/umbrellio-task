<?php


namespace Art4es\file;


use Art4es\exceptions\FileNotFoundException;

interface IFile
{
    /**
     * @param string $mode
     * @return resource
     * @throws FileNotFoundException
     */
    public function open(string $mode = 'r');

    public function close(): bool;
}