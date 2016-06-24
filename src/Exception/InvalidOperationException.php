<?php

namespace Collections\Exception;

class InvalidOperationException extends Exception
{
    public static function unsupportedGet($class)
    {
        return new static(sprintf('Cannot access a property on a collection %', $class));
    }

    public static function unsupportedSet($class)
    {
        return new static(sprintf('Cannot access a property on a collection %', $class));
    }

    public static function unsupportedSetKey($class)
    {
        return new static(sprintf('Cannot set  an element of a % with a key', $class));
    }

    public static function unsupportedUnset($class)
    {
        return new static(sprintf('Cannot access a property on a collection %', $class));
    }
}
