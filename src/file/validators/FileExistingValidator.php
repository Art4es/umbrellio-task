<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\FileDoesNotExistsException;
use Art4es\file\IFile;

class FileExistingValidator extends Validator
{
    function configure(array $params = []): void
    {
    }

    /**
     * @param IFile $file
     * @return bool
     * @throws FileDoesNotExistsException
     */
    public function validate(IFile $file): bool
    {
        try {
            $fileStream = fopen($file->getPath(), 'r');
            if (!$fileStream) {
                throw new FileDoesNotExistsException();
            }
        } catch (\Throwable $e) {
            throw new FileDoesNotExistsException();
        }
        return fclose($fileStream);
    }


}