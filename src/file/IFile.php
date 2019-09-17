<?php


namespace Art4es\file;


use phpDocumentor\Reflection\Types\Resource_;

interface IFile
{
    public function open(string $mode = 'r'): Resource_;
    public function close(): bool;
}