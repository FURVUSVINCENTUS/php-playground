<?php

namespace Amp\Sync;

final class StaticKeyMutex implements Mutex
{
    private KeyedMutex $mutex;

    private string $key;

    public function __construct(KeyedMutex $mutex, string $key)
    {
        $this->mutex = $mutex;
        $this->key = $key;
    }

    public function acquire(): Lock
    {
        return $this->mutex->acquire($this->key);
    }
}
