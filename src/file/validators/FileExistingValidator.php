<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\FileDoesNotExistsException;
use Art4es\file\IFile;

class FileExistingValidator implements IValidator
{

    /**
     * @param IFile $file
     * @throws FileDoesNotExistsException
     */
    public function validate(IFile $file)
    {
        try {
            $fileStream = fopen($file->getPath(), 'r');
            if (!$fileStream) {
                throw new FileDoesNotExistsException();
            }
        } catch (\Throwable $e) {
            throw new FileDoesNotExistsException();
        }
        fclose($fileStream);
    }
}