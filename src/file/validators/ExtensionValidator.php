<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\ExtensionDoesNotSupportException;
use Art4es\file\IFile;

class ExtensionValidator implements IValidator
{

    private $extensions = [];

    public function __construct(array $availableExtensions = [])
    {
        $this->extensions = $availableExtensions;
    }

    /**
     * @param IFile $file
     * @throws ExtensionDoesNotSupportException
     */
    public function validate(IFile $file)
    {
        $info = new \SplFileInfo($file->getPath());
        if (!in_array($info->getExtension(), $this->extensions)) {
            throw new ExtensionDoesNotSupportException();
        }
    }
}