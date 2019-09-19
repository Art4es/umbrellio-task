<?php


namespace Art4es\file\validators;


use Art4es\exceptions\validator\MimeTypeDoesNotSupportException;
use Art4es\file\IFile;

class MimeTypeValidator implements IValidator
{
    private $mimeTypes = [];

    public function __construct(array $availableMimeTypes = [])
    {
        $this->mimeTypes = $availableMimeTypes;
    }

    /**
     * @param IFile $file
     * @return bool
     * @throws MimeTypeDoesNotSupportException
     */
    public function validate(IFile $file): bool
    {
        $mimeType = mime_content_type($file->getPath());
        if (!in_array($mimeType, $this->mimeTypes)) {
            throw new MimeTypeDoesNotSupportException();
        }
        return true;
    }
}