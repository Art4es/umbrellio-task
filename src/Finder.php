<?php


namespace Art4es;


use Art4es\config\IConfigParser;
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

    public function __construct(IFile $file, IStrategy $strategy, IConfigParser $parser = null)
    {
        $this->file = $file;
        $this->strategy = $strategy;

        if (!empty($parser)) {
            foreach ($parser->getValidators() as $validator) {
                array_push($this->validators, $validator);
            }
        }
    }

    public function execute()
    {
        (new FileExistingValidator())->validate($this->file);
        $this->validate();
        return $this->strategy->search($this->file);
    }

    private function validate()
    {
        foreach ($this->validators as $validator) {
            $validator->validate($this->file);
        }
    }

    public function setNewFile(IFile $newFile)
    {
        $this->file = $newFile;
    }

    public function setNewStrategy(IStrategy $newStrategy)
    {
        $this->strategy = $newStrategy;
    }
}