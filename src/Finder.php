<?php


namespace Art4es;


use Art4es\file\IFile;
use Art4es\file\validators\FileExistingValidator;
use Art4es\file\validators\IValidator;
use Art4es\strategies\IStrategy;

class Finder implements IFinder
{
    private $file;
    private $strategy;
    /** @var IValidator[] */
    private $validators = [];

    public function __construct(IFile $file, IStrategy $strategy)
    {
        $this->file = $file;
        $this->strategy = $strategy;
        array_push($this->validators, new FileExistingValidator());
    }

    public function execute()
    {
        $this->validate();
        return $this->strategy->search($this->file);
    }

    private function validate()
    {
        foreach ($this->validators as $validator) {
            $validator->validate($this->file);
        }
    }

    public function setFile(IFile $newFile)
    {
        $this->file = $newFile;
    }

    public function setStrategy(IStrategy $newStrategy)
    {
        $this->strategy = $newStrategy;
    }
}