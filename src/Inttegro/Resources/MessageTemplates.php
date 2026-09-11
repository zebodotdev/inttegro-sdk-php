<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Client operations for Inttegro message templates.
 *
 * Request arrays use the API's documented `snake_case` field names. Responses
 * are returned as immutable values from the corresponding singular namespace.
 */
class MessageTemplates
{
    /**
     * Creates the message templates resource client.
     *
     * @param HttpClient $http Shared authenticated HTTP transport used by this resource client.
     */
    public function __construct(private HttpClient $http)
    {
    }

    /**
     * Creates a new message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\MessageTemplate\MessageTemplate The created message template.
     */
    public function create(array $payload, ?string $idempotencyKey = null): \Inttegro\MessageTemplate\MessageTemplate
    {
        return $this->http->postResource('/message_templates/create', \Inttegro\MessageTemplate\MessageTemplate::class, 'message_template', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    /**
     * Updates the supplied fields on the message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\MessageTemplate\MessageTemplate The updated message template.
     */
    public function update(array $payload, ?string $idempotencyKey = null): \Inttegro\MessageTemplate\MessageTemplate
    {
        return $this->http->postResource('/message_templates/update', \Inttegro\MessageTemplate\MessageTemplate::class, 'message_template', $payload, $this->idempotencyHeaders($idempotencyKey));
    }

    /**
     * Publishes the message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $templateId Unique identifier of the template.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\MessageTemplate\MessageTemplate The resulting message template.
     */
    public function publish(string $templateId, ?string $idempotencyKey = null): \Inttegro\MessageTemplate\MessageTemplate
    {
        return $this->http->postResource('/message_templates/publish', \Inttegro\MessageTemplate\MessageTemplate::class, 'message_template', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    /**
     * Archives the message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $templateId Unique identifier of the template.
     * @param ?string $idempotencyKey Optional idempotency key for safely retrying the same logical write.
     * @return \Inttegro\MessageTemplate\MessageTemplate The archived message template.
     */
    public function archive(string $templateId, ?string $idempotencyKey = null): \Inttegro\MessageTemplate\MessageTemplate
    {
        return $this->http->postResource('/message_templates/archive', \Inttegro\MessageTemplate\MessageTemplate::class, 'message_template', ['id' => $templateId], $this->idempotencyHeaders($idempotencyKey));
    }

    /**
     * Retrieves the requested message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param string $templateId Unique identifier of the template.
     * @return \Inttegro\MessageTemplate\MessageTemplate The requested message template.
     */
    public function lookup(string $templateId): \Inttegro\MessageTemplate\MessageTemplate
    {
        return $this->http->postResource('/message_templates/lookup', \Inttegro\MessageTemplate\MessageTemplate::class, 'message_template', ['id' => $templateId]);
    }

    /**
     * Retrieves a paginated collection of message templates.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\MessageTemplate\Page A typed page of matching message templates.
     */
    public function page(array $payload = []): \Inttegro\MessageTemplate\Page
    {
        return $this->http->postResource('/message_templates/page', \Inttegro\MessageTemplate\Page::class, 'page', $payload);
    }

    /**
     * Performs the `renderPreview` operation for the message template.
     *
     * Sends the documented request through the shared authenticated transport and hydrates the
     * successful response into the declared return type.
     *
     * @param array<string, mixed> $payload Request fields keyed by the documented `snake_case` API names.
     * @return \Inttegro\MessageTemplate\Preview The resulting preview.
     */
    public function renderPreview(array $payload): \Inttegro\MessageTemplate\Preview
    {
        return $this->http->postValue('/message_templates/render_preview', \Inttegro\MessageTemplate\Preview::class, $payload);
    }

    private function idempotencyHeaders(?string $idempotencyKey): array
    {
        return $idempotencyKey === null || trim($idempotencyKey) === ''
            ? []
            : ['Idempotency-Key' => $idempotencyKey];
    }
}
