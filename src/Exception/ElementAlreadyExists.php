<?php

namespace Collections\Exception;

class ElementAlreadyExists extends Exception
{
    public static function duplicatedElement($element)
    {
        if (!is_string($element)) {
            $element = '';
        }

        return new static(sprintf("The element %s already exists", $element));
    }
}
