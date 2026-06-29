<?php

namespace Commerce;

class FileDownload
{
    public function __construct(
        public string $data,
        public array $headers = []
    ) {
    }

    public function saveTo(string $path): void
    {
        file_put_contents($path, $this->data);
    }
}
