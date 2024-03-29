<?php

namespace Amp\Process\Internal\Windows;

use Amp\Cancellation;
use Amp\DeferredFuture;

/**
 * A barrier is a synchronization primitive.
 *
 * The barrier is initialized with a certain count, which can be increased and decreased until it reaches zero.
 *
 * A count of one can be used to block multiple coroutines until a certain condition is met.
 *
 * A count of N can be used to await multiple coroutines doing an action to complete.
 *
 * **Example**
 *
 * ```php
 * $barrier = new Barrier(2);
 * $barrier->arrive();
 * $barrier->arrive(); // Barrier::await() returns immediately now
 *
 * $barrier->await();
 * ```
 */
final class Barrier
{
    private int $count;

    private DeferredFuture $completion;

    /**
     * @param int $count
     *
     * @psalm-param positive-int $count
     */
    public function __construct(int $count)
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if ($count < 1) {
            throw new \Error('Count must be positive, got ' . $count);
        }

        $this->count = $count;
        $this->completion = new DeferredFuture;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @psalm-param positive-int $count
     */
    public function arrive(int $count = 1): void
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if ($count < 1) {
            throw new \Error('Count must be at least 1, got ' . $count);
        }

        if ($count > $this->count) {
            throw new \Error('Count cannot be greater than remaining count: ' . $count . ' > ' . $this->count);
        }

        $this->count -= $count;

        if ($this->count === 0) {
            $this->completion->complete();
        }
    }

    public function await(?Cancellation $cancellation = null): void
    {
        $this->completion->getFuture()->await($cancellation);
    }
}
