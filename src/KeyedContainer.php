<?php

namespace Collections;

/**
 * Represents an entity that can be iterated over using foreach, allowing a key,
 * except it does not include objects that implement `KeyedIterator` nor `Set` and `ImmSet`.
 */
interface KeyedContainer extends Container, KeyedTraversable
{

}
