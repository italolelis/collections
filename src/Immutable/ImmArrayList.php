<?php

namespace Collections\Immutable;

use Collections\ConstVectorInterface;

class ImmArrayList extends AbstractImmCollection implements ConstVectorInterface
{
    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        $offset = $this->intGuard($key);

        return array_key_exists((int)$offset, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index)
    {
        $offset = $this->existsGuard($this->intGuard($index));

        return $this->storage[$offset];
    }
}