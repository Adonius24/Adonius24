<?php
namespace App\Services\Carriers;

interface CarrierInterface
{
    public function name(): string;

    public function track(string $trackingNumber): array;
}
