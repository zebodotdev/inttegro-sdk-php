<?php

namespace Commerce;

class CommerceError extends \Exception
{
}

class NetworkError extends CommerceError
{
    public ?\Throwable $previousError;

    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->previousError = $previous;
    }
}

class TimeoutError extends NetworkError
{
}

class APIError extends CommerceError
{
    public int $status;
    public ?string $code;
    public $body;
    public $data;

    public function __construct(string $message, int $status, ?string $code = null, $body = null, $data = null)
    {
        parent::__construct($message);
        $this->status = $status;
        $this->code = $code;
        $this->body = $body;
        $this->data = $data;
    }
}

class AuthenticationError extends APIError
{
}

class RateLimitError extends APIError
{
    public ?int $retryAfter;

    public function __construct(
        string $message,
        int $status,
        ?string $code = null,
        $body = null,
        $data = null,
        ?int $retryAfter = null
    ) {
        parent::__construct($message, $status, $code, $body, $data);
        $this->retryAfter = $retryAfter;
    }
}
