<?php


namespace Art4es\exceptions;


class FileNotFoundException extends \Exception
{
    protected $message = "Can't find file";
}