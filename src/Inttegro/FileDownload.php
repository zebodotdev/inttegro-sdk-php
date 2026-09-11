<?php

namespace Inttegro;

/**
 * Binary file contents and response headers returned by a download operation.
 *
 * The SDK keeps binary data in memory until the application reads `data` or calls `saveTo()`.
 */
class FileDownload
{
    /**
     * Creates an in-memory download result.
     *
     * @param string $data Raw binary response body.
     * @param array<string, string> $headers Response headers keyed by normalized header name.
     */
    public function __construct(
        /** Raw binary response body. */
        public string $data,
        /** @var array<string, string> Response headers keyed by normalized header name. */
        public array $headers = []
    ) {
    }

    /**
     * Writes the complete binary response body to a local path.
     *
     * @param string $path Destination path writable by the current PHP process.
     */
    public function saveTo(string $path): void
    {
        file_put_contents($path, $this->data);
    }
}
