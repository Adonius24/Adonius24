# OpenTrack Logistics Lab

This repository contains a self-contained PHP prototype that mimics a Laravel + Livewire tracking dashboard. It autodetects carriers, shows simulated near-real-time events, and exposes an API for triggering WhatsApp notifications.

> **Important**: The code runs without Composer or npm installs by using lightweight PHP wiring and CDN-hosted UI libraries (Bootstrap, Tailwind, jQuery). When you are ready to plug it into a full Laravel project, copy the `app`, `resources`, `routes`, and `public` directories into a fresh Laravel installation and wire the services into proper controllers/components.

## Features
- Auto-detects carriers by regex patterns and uses mock data to simulate global carriers (FedEx, UPS, DHL, USPS, Correios). Add more by editing `storage/data/carriers.json`.
- Front-end uses Bootstrap 5, Tailwind, jQuery, and a minimal Livewire-inspired event emitter to keep the component reactive.
- `/api/track` endpoint streams tracking information assembled by the `TrackingAggregator`.
- `/api/whatsapp/send` endpoint shows how to send WhatsApp notifications; by default, it logs payloads to `storage/logs/notifications.log` so you can verify them locally.
- Extensible service classes for plugging in real carrier APIs or scraping logic if you have permission from the carrier.

## Quick start
```bash
cd tracker
php -S localhost:8000 -t public
```
Visit <http://localhost:8000> and test with any of the included sample numbers:
- FedEx: `771234567890`
- UPS: `1Z999AA10123456784`
- DHL: `1234567890`
- USPS: `CH123456789US`
- Correios: `BR123456789BR`

Add your phone number (E.164 format) to log WhatsApp notifications.

## Adding carriers
Edit `storage/data/carriers.json` and append entries:
```json
{
  "code": "aramex",
  "name": "Aramex",
  "service": "Priority",
  "eta": "2024-05-01",
  "patterns": ["\\b[0-9]{11}\\b"],
  "webhook": "https://api.aramex.com/webhooks",
  "mock_events": [
    { "status": "Picked up", "description": "Package received", "location": "Dubai, AE", "timestamp": "2024-04-20T10:00:00Z" }
  ]
}
```
Restart the PHP dev server to reload the repository.

## Enabling real WhatsApp delivery
1. Create a WhatsApp Cloud API or Twilio WhatsApp sender.
2. Replace `YOUR_TOKEN` inside `app/Http/Controllers/WhatsappController.php` with the API token.
3. Update `WhatsappNotifier` to perform an actual `curl` request (the scaffolding is ready; just swap the logging implementation).

## Deploying behind Laravel
If you want a full Laravel project:
1. On a machine with Composer, run `composer create-project laravel/laravel tracker-app`.
2. Copy the `app`, `routes`, `resources`, and `public` subdirectories from this repo into `tracker-app` (overwriting the defaults).
3. Register the routes in `routes/web.php`/`routes/api.php` or convert the controllers into proper Laravel controllers.
4. Install Livewire via Composer and replace the lightweight emitter with real Livewire components for server-driven updates.

## Testing
Because the stack is framework-light, manual testing is performed via the browser and the built-in PHP server. Tracking lookups and WhatsApp requests are logged to `storage/logs` for auditing.
