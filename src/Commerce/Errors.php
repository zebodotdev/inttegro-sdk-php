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
    public $code;
    public ?string $type;
    public ?string $url;
    public ?string $detail;
    public ?string $fixCode;
    public ?string $cause;
    public $body;
    public $data;

    public function __construct(
        string $message,
        int $status,
        ?string $code = null,
        ?string $type = null,
        ?string $url = null,
        ?string $detail = null,
        ?string $fixCode = null,
        ?string $cause = null,
        $body = null,
        $data = null
    ) {
        parent::__construct($message);
        $this->status = $status;
        $this->code = $code;
        $this->type = $type;
        $this->url = $url;
        $this->detail = $detail;
        $this->fixCode = $fixCode;
        $this->cause = $cause;
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
        ?string $type = null,
        ?string $url = null,
        ?string $detail = null,
        ?string $fixCode = null,
        ?string $cause = null,
        $body = null,
        $data = null,
        ?int $retryAfter = null
    ) {
        parent::__construct($message, $status, $code, $type, $url, $detail, $fixCode, $cause, $body, $data);
        $this->retryAfter = $retryAfter;
    }
}
