<?php

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_CALLBACK, function ($file, $line, $code, $desc = null) {
    $message = "Assertion failed at $file:$line";
    if ($desc) {
        $message .= " - $desc";
    }
    throw new Exception($message);
});

function assertEquals($expected, $actual, string $message = ''): void
{
    assert($expected === $actual, $message ?: "Expected " . var_export($expected, true) . " got " . var_export($actual, true));
}

function assertTrue($condition, string $message = ''): void
{
    assert((bool)$condition, $message ?: "Condition was not true");
}
