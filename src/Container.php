<?php

namespace Collections;

/**
 * Represents an entity that can be iterated over using foreach, without requiring a key,
 * except it does not include objects that implement `Iterator`.
 */
interface Container extends \Traversable
{

}
