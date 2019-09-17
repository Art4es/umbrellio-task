<?php


namespace Art4es\file;


interface IFile
{
    public function open(string $mode = 'r');

    public function close(): bool;
}