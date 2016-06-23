<?php

namespace Collections\Exception;

class InvalidArgumentException extends \Exception
{
    public static function invalidTraversable()
    {
        return new static('The items must be an array or Traversable');
    }
}
