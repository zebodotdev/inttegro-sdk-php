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

    public function __construct(string $apiKey, string $baseUrl = 'https://api.inttegro.com', int $timeout = 30, $adapter = null)
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

    public function postWithHeaders(string $path, ?array $body = null, array $headers = []): ResponseObject
    {
        $url = $this->buildUrl($path, []);
        $body = $body ?? [];
        $body = $this->isIdempotentMutationPath($path) && !$this->hasHeader($headers, 'Idempotency-Key')
            ? $this->withRequestMetaIdempotency($body)
            : $this->withoutTopLevelIdempotencyKey($body);
        $requestHeaders = [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'User-Agent: ' . $this->userAgent,
        ];
        foreach ($headers as $key => $value) {
            $requestHeaders[] = $key . ': ' . $value;
        }

        $response = $this->send('POST', $url, $requestHeaders, json_encode($body));
        return $this->responseObject($response);
    }

    public function postMultipart(string $path, array $fields, array $files, array $headers = [], bool $authenticated = true): ResponseObject
    {
        $url = $this->buildUrl($path, []);
        $requestHeaders = ['Accept: application/json', 'User-Agent: ' . $this->userAgent];
        if ($authenticated) {
            $requestHeaders[] = 'Authorization: Bearer ' . $this->apiKey;
        }
        if ($authenticated && $this->isIdempotentMutationPath($path) && !$this->hasHeader($headers, 'Idempotency-Key')) {
            $headers['Idempotency-Key'] = $this->generateIdempotencyKey();
        }
        foreach ($headers as $key => $value) {
            $requestHeaders[] = $key . ': ' . $value;
        }

        foreach ($fields as $key => $value) {
            if ($value === null) {
                unset($fields[$key]);
            } elseif (is_array($value)) {
                $fields[$key] = json_encode($value);
            }
        }
        foreach ($files as $key => $path) {
            $fields[$key] = new \CURLFile($path);
        }

        $response = $this->send('POST', $url, $requestHeaders, $fields);
        return $this->responseObject($response);
    }

    public function postBinaryJson(string $path, array $body): FileDownload
    {
        $url = $this->buildUrl($path, []);
        $body = $this->withoutTopLevelIdempotencyKey($body);
        $headers = [
            'Accept: application/octet-stream',
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'User-Agent: ' . $this->userAgent,
        ];
        $response = $this->send('POST', $url, $headers, json_encode($body));
        if ($response['status'] >= 400) {
            $this->handleErrorResponse($response);
        }
        return new FileDownload($response['body'], $response['headers']);
    }

    public function getBinaryPublic(string $url): FileDownload
    {
        $headers = ['User-Agent: ' . $this->userAgent];
        $response = $this->send('GET', $url, $headers, null);
        if ($response['status'] >= 400) {
            $this->handleErrorResponse($response);
        }
        return new FileDownload($response['body'], $response['headers']);
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
            $body = strtoupper($method) === 'POST' && $this->isIdempotentMutationPath($path)
                ? $this->withRequestMetaIdempotency($body)
                : $this->withoutTopLevelIdempotencyKey($body);
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

        return $this->responseObject($response);
    }

    private function withRequestMetaIdempotency(array $body): array
    {
        $payload = $this->withoutTopLevelIdempotencyKey($body);
        $requestMeta = isset($payload['request_meta']) && is_array($payload['request_meta'])
            ? $payload['request_meta']
            : [];
        $existingKey = $requestMeta['idempotency_key'] ?? null;
        if (!is_string($existingKey) || trim($existingKey) === '') {
            $requestMeta['idempotency_key'] = $this->generateIdempotencyKey();
        }
        $payload['request_meta'] = $requestMeta;
        return $payload;
    }

    private function withoutTopLevelIdempotencyKey(array $body): array
    {
        unset($body['idempotency_key']);
        return $body;
    }

    private function isIdempotentMutationPath(string $pathOrUrl): bool
    {
        $path = (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://'))
            ? (parse_url($pathOrUrl, PHP_URL_PATH) ?: '')
            : $pathOrUrl;
        $parts = array_values(array_filter(explode('/', trim($path, '/')), static fn($part) => $part !== ''));
        $action = $parts[count($parts) - 1] ?? '';
        return !in_array($action, ['', 'lookup', 'page', 'settings', 'countries', 'contents', 'balances', 'render_preview'], true);
    }

    private function hasHeader(array $headers, string $name): bool
    {
        foreach ($headers as $key => $value) {
            if (strtolower((string)$key) === strtolower($name) && trim((string)$value) !== '') {
                return true;
            }
        }
        return false;
    }

    private function generateIdempotencyKey(): string
    {
        $timestampMs = (int)floor(microtime(true) * 1000) & ((1 << 48) - 1);
        $random = array_values(unpack('C*', random_bytes(10)));
        $bytes = [
            ($timestampMs >> 40) & 0xff,
            ($timestampMs >> 32) & 0xff,
            ($timestampMs >> 24) & 0xff,
            ($timestampMs >> 16) & 0xff,
            ($timestampMs >> 8) & 0xff,
            $timestampMs & 0xff,
            ($random[0] & 0x0f) | 0x70,
            $random[1],
            ($random[2] & 0x3f) | 0x80,
            $random[3],
            $random[4],
            $random[5],
            $random[6],
            $random[7],
            $random[8],
            $random[9],
        ];
        $hex = implode('', array_map(static fn($byte) => str_pad(dechex($byte), 2, '0', STR_PAD_LEFT), $bytes));
        return substr($hex, 0, 8) . '-' . substr($hex, 8, 4) . '-' . substr($hex, 12, 4) . '-' . substr($hex, 16, 4) . '-' . substr($hex, 20);
    }

    private function responseObject(array $response): ResponseObject
    {
        $status = $response['status'];
        $rawBody = $response['body'];
        $data = $this->parseJson($rawBody);

        if ($status < 400) {
            return new ResponseObject(is_array($data) ? $data : []);
        }

        $this->handleErrorResponse($response, $data);
        throw new \LogicException('Unreachable response handling state.');
    }

    private function handleErrorResponse(array $response, $data = null): void
    {
        $status = $response['status'];
        $rawBody = $response['body'];
        $data = $data ?? $this->parseJson($rawBody);
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

    private function send(string $method, string $url, array $headers, $payload): array
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
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
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
