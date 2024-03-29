<?php

namespace Amp\Internal;

/**
 * Formats a stacktrace obtained via `debug_backtrace()`.
 *
 * @param list<array{args?:list<mixed>, class?: class-string, file: string, function: string, line: int, object?: object, type?: string}> $trace
 * Output of `debug_backtrace()`.
 *
 * @return string Formatted stacktrace.
 *
 * @codeCoverageIgnore
 * @internal
 */
function formatStacktrace(array $trace): string
{
    return \implode("\n", \array_map(static function ($e, $i) {
        $line = "#{$i} ";

        if (isset($e["file"])) {
            $line .= "{$e['file']}:{$e['line']} ";
        }

        if (isset($e["class"], $e["type"])) {
            $line .= $e["class"] . $e["type"];
        }

        return $line . $e["function"] . "()";
    }, $trace, \array_keys($trace)));
}

/**
 * Creates a `TypeError` with a standardized error message.
 *
 * @param string[] $expected Expected types.
 * @param mixed    $given Given value.
 *
 * @return \TypeError
 *
 * @internal
 */
function createTypeError(array $expected, mixed $given): \TypeError
{
    $givenType = \is_object($given) ? \sprintf("instance of %s", \get_class($given)) : \gettype($given);

    if (\count($expected) === 1) {
        $expectedType = "Expected the following type: " . \array_pop($expected);
    } else {
        $expectedType = "Expected one of the following types: " . \implode(", ", $expected);
    }

    return new \TypeError("{$expectedType}; {$givenType} given");
}

/**
 * @return bool True if AMP_DEBUG is set to a truthy value.
 */
function isDebugEnabled(): bool
{
    $env = \getenv("AMP_DEBUG") ?: "0";
    return ($env !== "0" && $env !== "false") || (\defined("AMP_DEBUG") && \AMP_DEBUG);
}
