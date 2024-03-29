<?php

namespace Amp\Sync;

use Revolt\EventLoop;

/**
 * A handle on an acquired lock from a synchronization object.
 *
 * This object is not thread-safe; after acquiring a lock from a mutex or semaphore, the lock should reside in the same
 * thread or process until it is released.
 */
final class Lock
{
    /** @var \Closure|null The function to be called on release or null if the lock has been released. */
    private ?\Closure $release;

    /**
     * Creates a new lock permit object.
     *
     * @param \Closure(self): void $release A function to be called upon release.
     */
    public function __construct(\Closure $release)
    {
        $this->release = $release;
    }

    /**
     * Checks if the lock has already been released.
     *
     * @return bool True if the lock has already been released, otherwise false.
     */
    public function isReleased(): bool
    {
        return $this->release === null;
    }

    /**
     * Releases the lock. No-op if the lock has already been released.
     */
    public function release(): void
    {
        if ($this->release === null) {
            return;
        }

        // Invoke the releaser function given to us by the synchronization source to release the lock.
        EventLoop::queue($this->release);
        $this->release = null;
    }

    /**
     * Releases the lock when there are no more references to it.
     */
    public function __destruct()
    {
        if (!$this->isReleased()) {
            $this->release();
        }
    }
}
