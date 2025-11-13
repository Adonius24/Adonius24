<?php
namespace App\Services\Carriers;

class GenericCarrierClient implements CarrierInterface
{
    public function __construct(private string $carrierCode, private array $config)
    {
    }

    public function name(): string
    {
        return $this->config['name'] ?? $this->carrierCode;
    }

    public function track(string $trackingNumber): array
    {
        $mockData = $this->config['mock_events'] ?? [];
        $events = [];
        foreach ($mockData as $event) {
            $events[] = [
                'status' => $event['status'],
                'description' => $event['description'],
                'location' => $event['location'],
                'timestamp' => $event['timestamp'],
            ];
        }

        return [
            'tracking_number' => $trackingNumber,
            'carrier' => $this->name(),
            'service' => $this->config['service'] ?? 'Standard',
            'eta' => $this->config['eta'] ?? null,
            'events' => $events,
        ];
    }
}
