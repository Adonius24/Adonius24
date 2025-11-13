<?php
namespace App\Http\Controllers;

use App\Services\CarrierDetector;
use App\Services\CarrierRepository;
use App\Services\TrackingAggregator;

class TrackingController
{
    private TrackingAggregator $aggregator;

    public function __construct()
    {
        $repository = new CarrierRepository();
        $detector = new CarrierDetector($repository);
        $this->aggregator = new TrackingAggregator($detector);
    }

    public function index()
    {
        $html = $this->renderView('home', [
            'carriers' => (new CarrierRepository())->all(),
        ]);
        echo $html;
    }

    public function track()
    {
        header('Content-Type: application/json');
        $trackingNumber = $_GET['tracking_number'] ?? '';
        if (!$trackingNumber) {
            echo json_encode(['error' => 'Tracking number is required']);
            return;
        }
        $data = $this->aggregator->track($trackingNumber);
        echo json_encode($data);
    }

    private function renderView(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../../../resources/views/' . $view . '.php';
        return ob_get_clean();
    }
}
