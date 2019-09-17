<?php


namespace Art4es\exceptions;


class SubstringNotFoundException extends \Exception
{
    protected $message = "Can't find substring in this file";
}