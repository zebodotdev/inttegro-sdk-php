<?php

namespace Inttegro;

/** Base exception for failures raised by the Inttegro SDK. */
class InttegroError extends \Exception
{
    /** Privacy-safe terminal failure report when application-owned reporting is enabled. */
    public ?ErrorReport $report = null;
}

/** Failure to reach the Inttegro API or obtain a usable transport response. */
class NetworkError extends InttegroError
{
    /** Original transport failure, when one was supplied by the adapter. */
    public ?\Throwable $previousError;

    /**
     * Creates a network error while retaining its original cause.
     *
     * @param string $message Safe failure summary.
     * @param \Throwable|null $previous Original transport failure.
     */
    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->previousError = $previous;
    }
}

/** Network failure caused specifically by the configured request timeout. */
class TimeoutError extends NetworkError
{
}

/** Structured non-success response returned by the Inttegro API. */
class APIError extends InttegroError
{
    /** HTTP response status. */
    public int $status;
    /** Machine-readable API error code, when present. @var string|int|null */
    public $code;
    /** Broad machine-readable error type. */
    public ?string $type;
    /** Static request URL or route associated with the failure, when safe to expose. */
    public ?string $url;
    /** Human-readable detail returned by the API. */
    public ?string $detail;
    /** Machine-readable remediation code, when the API supplies one. */
    public ?string $fixCode;
    /** Public cause description returned by the API. */
    public ?string $cause;
    /** Decoded or raw error response body. @var mixed */
    public $body;
    /** Structured API error data. @var mixed */
    public $data;
    /** Server request identifier used to correlate logs and support cases. */
    public ?string $requestId;

    /**
     * Creates a structured API response error.
     *
     * @param string $message Exception message.
     * @param int $status HTTP response status.
     * @param string|null $code Machine-readable API error code.
     * @param string|null $type Broad error category.
     * @param string|null $url Safe request URL or static route.
     * @param string|null $detail Human-readable API detail.
     * @param string|null $fixCode Machine-readable remediation code.
     * @param string|null $cause Public cause description.
     * @param mixed $body Decoded or raw error response body.
     * @param mixed $data Structured API error data.
     * @param string|null $requestId Server request identifier.
     */
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
        ?string $requestId = null
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
        $this->requestId = $requestId;
    }
}

/** API error indicating that the supplied secret key was missing, invalid, or unauthorized. */
class AuthenticationError extends APIError
{
}

/** API error indicating that the caller exceeded a request rate limit. */
class RateLimitError extends APIError
{
    /** Number of seconds the server recommends waiting before retrying, when supplied. */
    public ?int $retryAfter;

    /**
     * Creates a rate-limit error with optional retry timing.
     *
     * @param string $message Exception message.
     * @param int $status HTTP response status.
     * @param string|null $code Machine-readable API error code.
     * @param string|null $type Broad error category.
     * @param string|null $url Safe request URL or static route.
     * @param string|null $detail Human-readable API detail.
     * @param string|null $fixCode Machine-readable remediation code.
     * @param string|null $cause Public cause description.
     * @param mixed $body Decoded or raw error response body.
     * @param mixed $data Structured API error data.
     * @param int|null $retryAfter Recommended delay in seconds before retrying.
     * @param string|null $requestId Server request identifier.
     */
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
        ?int $retryAfter = null,
        ?string $requestId = null
    ) {
        parent::__construct($message, $status, $code, $type, $url, $detail, $fixCode, $cause, $body, $data, $requestId);
        $this->retryAfter = $retryAfter;
    }
}
