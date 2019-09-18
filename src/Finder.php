<?php


namespace Art4es;


use Art4es\file\IFile;
use Art4es\strategies\IStrategy;

class Finder implements IFinder
{
    private $file;
    private $strategy;

    public function __construct(IFile $file, IStrategy $strategy)
    {
        $this->file = $file;
        $this->strategy = $strategy;
    }

    public function execute()
    {
        return $this->strategy->search($this->file);
    }
}