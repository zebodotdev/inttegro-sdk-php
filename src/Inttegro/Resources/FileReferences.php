<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

class FileReferences
{
    public function __construct(private HttpClient $http)
    {
    }

    public function reconcile(array $payload): \Inttegro\FileReferenceReconciliation
    {
        return $this->http->postValue('/file_references/reconcile', \Inttegro\FileReferenceReconciliation::class, $payload);
    }
}
