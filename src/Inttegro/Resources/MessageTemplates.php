<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;
use Inttegro\ResponseObject;

class MessageTemplates
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders('/message_templates/create', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    public function update(array $payload, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders('/message_templates/update', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    public function publish(string $templateId, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders('/message_templates/publish', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    public function archive(string $templateId, ?string $idempotencyKey = null): ResponseObject
    {
        return $this->http->postWithHeaders('/message_templates/archive', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    public function lookup(string $templateId): ResponseObject
    {
        return $this->http->post('/message_templates/lookup', ['id' => $templateId]);
    }

    public function page(array $payload = []): ResponseObject
    {
        return $this->http->post('/message_templates/page', $payload);
    }

    public function renderPreview(array $payload): ResponseObject
    {
        return $this->http->post('/message_templates/render_preview', $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey === null || trim($idempotencyKey) === ''
            ? []
            : ['Idempotency-Key' => $idempotencyKey];
    }
}
