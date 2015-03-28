<?php

namespace Hospect\Exception;

class LinksLimitExceededException extends \RuntimeException
{
    protected $message = "Sorry, we can't do it for you. Please, try to set lower nesting level.";
} 
