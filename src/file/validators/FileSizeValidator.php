<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\IncorrectFileSizeException;
use Art4es\file\IFile;

class FileSizeValidator implements IValidator
{
    private $minSize;
    private $maxSize;

    public function __construct($minSize = 0, $maxSize = null)
    {
        $this->minSize = $minSize;
        $this->maxSize = $maxSize;
    }

    /**
     * @param IFile $file
     * @return bool
     * @throws IncorrectFileSizeException
     */
    public function validate(IFile $file): bool
    {
        $fileSize = filesize($file->getPath());
        if ($fileSize < $this->minSize) {
            throw new IncorrectFileSizeException();
        }

        if (!empty($this->maxSize)) {
            if ($fileSize > $this->maxSize) {
                throw new IncorrectFileSizeException();
            }
        }
        return true;
    }
}