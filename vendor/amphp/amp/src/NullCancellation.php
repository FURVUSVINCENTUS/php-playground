<?php

namespace Amp;

/**
 * A NullCancellation can be used to avoid conditionals to check whether a cancellation has been provided.
 *
 * Instead of writing
 *
 * ```php
 * if ($cancellation) {
 *     $cancellation->throwIfRequested();
 * }
 * ```
 *
 * potentially multiple times, it allows writing
 *
 * ```php
 * $cancellation = $cancellation ?? new NullCancellation;
 *
 * // ...
 *
 * $cancellation->throwIfRequested();
 * ```
 *
 * instead.
 */
final class NullCancellation implements Cancellation
{
    public function subscribe(\Closure $callback): string
    {
        return "null-cancellation";
    }

    /** @inheritdoc */
    public function unsubscribe(string $id): void
    {
        // nothing to do
    }

    /** @inheritdoc */
    public function isRequested(): bool
    {
        return false;
    }

    /** @inheritdoc */
    public function throwIfRequested(): void
    {
        // nothing to do
    }
}
