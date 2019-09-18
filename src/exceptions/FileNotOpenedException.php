<?php


namespace Art4es\exceptions;


class FileNotOpenedException extends \Exception
{
    protected $message = "File wasn't opened yet";
}