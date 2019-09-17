<?php


namespace Art4es\strategies;


use Art4es\file\IFile;

interface IStrategy
{
    public function search(IFile $file);
}