<?php

namespace Commerce;

use Commerce\ResponseObject;

class HttpClient
{
    private string $apiKey;
    private string $baseUrl;
    private int $timeout;
    private $adapter;
    private string $userAgent;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.zebo.dev', int $timeout = 30, $adapter = null)
    {
        if (trim($apiKey) === '') {
            throw new \InvalidArgumentException('apiKey is required');
        }

        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->timeout = $timeout;
        $this->adapter = $adapter;
        $this->userAgent = 'zebo-commerce-sdk-php/' . Version::VERSION;
    }

    public function get(string $path, array $query = []): ResponseObject
    {
        return $this->request('GET', $path, null, $query);
    }

    public function post(string $path, ?array $body = null, array $query = []): ResponseObject
    {
        return $this->request('POST', $path, $body, $query);
    }

    private function request(string $method, string $path, ?array $body = null, array $query = []): ResponseObject
    {
        $url = $this->buildUrl($path, $query);
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->apiKey,
            'User-Agent: ' . $this->userAgent,
        ];

        $payload = null;
        if ($body !== null) {
            $headers[] = 'Content-Type: application/json';
            $payload = json_encode($body);
        }

        try {
            $response = $this->send($method, $url, $headers, $payload);
        } catch (\Throwable $e) {
            if ($e instanceof TimeoutError) {
                throw $e;
            }
            throw new NetworkError('Network request failed', $e);
        }

        $status = $response['status'];
        $rawBody = $response['body'];
        $data = $this->parseJson($rawBody);

        if ($status < 400) {
            return new ResponseObject(is_array($data) ? $data : []);
        }

        $payload = $this->extractErrorPayload($data);
        $message = $payload['message'] ?? $payload['detail'] ?? $this->extractErrorMessage($data, $status);
        $code = $payload['code'] ?? null;
        $type = $payload['type'] ?? null;
        $url = $payload['url'] ?? null;
        $detail = $payload['detail'] ?? null;
        $fixCode = $payload['fix_code'] ?? null;
        $cause = $payload['cause'] ?? null;

        if ($status === 401) {
            throw new AuthenticationError($message, $status, $code, $type, $url, $detail, $fixCode, $cause, $rawBody, $data);
        }

        if ($status === 429) {
            $retryAfter = isset($response['headers']['retry-after']) ? (int)$response['headers']['retry-after'] : null;
            throw new RateLimitError(
                $message,
                $status,
                $code,
                $type,
                $url,
                $detail,
                $fixCode,
                $cause,
                $rawBody,
                $data,
                $retryAfter
            );
        }

        throw new APIError($message, $status, $code, $type, $url, $detail, $fixCode, $cause, $rawBody, $data);
    }

    private function send(string $method, string $url, array $headers, ?string $payload): array
    {
        if ($this->adapter) {
            return call_user_func($this->adapter, $method, $url, $headers, $payload);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HEADER, true);
        if ($payload !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        if ($body === false) {
            if (in_array($errno, [CURLE_OPERATION_TIMEOUTED], true)) {
                throw new TimeoutError('Request timed out', null);
            }
            throw new NetworkError('cURL error: ' . $error);
        }

        $headers = [];
        if ($headerSize && $headerSize > 0) {
            $rawHeaders = substr($body, 0, $headerSize);
            foreach (explode("\r\n", $rawHeaders) as $line) {
                if (strpos($line, ':') !== false) {
                    [$k, $v] = explode(':', $line, 2);
                    $headers[strtolower(trim($k))] = trim($v);
                }
            }
            $body = substr($body, $headerSize);
        }

        return [
            'status' => $status,
            'body' => $body,
            'headers' => $headers,
        ];
    }

    private function buildUrl(string $path, array $query): string
    {
        $normalized = str_starts_with($path, '/') ? $path : '/' . $path;
        $url = $this->baseUrl . $normalized;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    private function parseJson(string $body)
    {
        if ($body === '') {
            return [];
        }
        $decoded = json_decode($body, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $body;
    }

    private function extractErrorMessage($data, int $status): string
    {
        if (is_array($data)) {
            return $data['error']['message'] ?? $data['message'] ?? $data['error'] ?? ("HTTP $status");
        }
        return "HTTP $status";
    }

    private function extractErrorPayload($data): array
    {
        if (!is_array($data)) {
            return [];
        }
        if (isset($data['error']) && is_array($data['error'])) {
            return $data['error'];
        }
        return $data;
    }
}
