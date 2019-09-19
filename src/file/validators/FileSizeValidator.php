<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\IncorrectFileSizeException;
use Art4es\file\IFile;

class FileSizeValidator extends Validator
{
    const MIN = 'min';
    const MAX = 'max';

    private $minSize;
    private $maxSize;

    function configure(array $params = []): void
    {
        $this->minSize = $params[self::MIN] ?? 0;
        $this->maxSize = $params[self::MAX] ?? null;
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

    /**
     * @return int
     */
    public function getMinSize()
    {
        return $this->minSize;
    }

    /**
     * @return null|int
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }
}