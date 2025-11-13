<?php
namespace App\Services;

class CarrierRepository
{
    private string $dataFile;

    public function __construct(?string $dataFile = null)
    {
        $this->dataFile = $dataFile ?? __DIR__ . '/../../storage/data/carriers.json';
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode(['carriers' => []], JSON_PRETTY_PRINT));
        }
    }

    public function all(): array
    {
        $payload = json_decode(file_get_contents($this->dataFile), true);
        return $payload['carriers'] ?? [];
    }
}
