<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class MessageTemplates
{
    public function __construct(private HttpClient $http)
    {
    }

    public function create(array $payload, ?string $idempotencyKey = null): \Inttegro\MessageTemplate
    {
        return $this->http->postResource('/message_templates/create', \Inttegro\MessageTemplate::class, 'message_template', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    public function update(array $payload, ?string $idempotencyKey = null): \Inttegro\MessageTemplate
    {
        return $this->http->postResource('/message_templates/update', \Inttegro\MessageTemplate::class, 'message_template', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    public function publish(string $templateId, ?string $idempotencyKey = null): \Inttegro\MessageTemplate
    {
        return $this->http->postResource('/message_templates/publish', \Inttegro\MessageTemplate::class, 'message_template', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    public function archive(string $templateId, ?string $idempotencyKey = null): \Inttegro\MessageTemplate
    {
        return $this->http->postResource('/message_templates/archive', \Inttegro\MessageTemplate::class, 'message_template', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    public function lookup(string $templateId): \Inttegro\MessageTemplate
    {
        return $this->http->postResource('/message_templates/lookup', \Inttegro\MessageTemplate::class, 'message_template', ['id' => $templateId]);
    }

    public function page(array $payload = []): \Inttegro\MessageTemplatesPage
    {
        return $this->http->postResource('/message_templates/page', \Inttegro\MessageTemplatesPage::class, 'page', $payload);
    }

    public function renderPreview(array $payload): \Inttegro\MessageTemplatePreview
    {
        return $this->http->postValue('/message_templates/render_preview', \Inttegro\MessageTemplatePreview::class, $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey === null || trim($idempotencyKey) === ''
            ? []
            : ['Idempotency-Key' => $idempotencyKey];
    }
}
