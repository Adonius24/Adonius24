<?php
namespace App\Services;

use App\Services\Carriers\CarrierInterface;
use App\Services\Carriers\GenericCarrierClient;

class TrackingAggregator
{
    public function __construct(private CarrierDetector $detector)
    {
    }

    public function track(string $trackingNumber): array
    {
        $carrier = $this->detector->detect($trackingNumber);
        if (!$carrier) {
            return [
                'tracking_number' => $trackingNumber,
                'carrier' => null,
                'events' => [],
                'message' => 'Carrier not found in knowledge base.'
            ];
        }

        $client = $this->buildClient($carrier);
        $data = $client->track($trackingNumber);
        $data['webhook'] = $carrier['webhook'] ?? null;
        $data['last_sync'] = date('c');
        return $data;
    }

    private function buildClient(array $carrier): CarrierInterface
    {
        return new GenericCarrierClient($carrier['code'], $carrier);
    }
}
