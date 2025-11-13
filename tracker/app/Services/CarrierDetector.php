<?php
namespace App\Services;

class CarrierDetector
{
    public function __construct(private CarrierRepository $repository)
    {
    }

    public function detect(string $trackingNumber): ?array
    {
        foreach ($this->repository->all() as $carrier) {
            foreach ($carrier['patterns'] as $pattern) {
                if (preg_match('/' . $pattern . '/i', $trackingNumber)) {
                    return $carrier;
                }
            }
        }
        return null;
    }
}
