<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Logistics Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="bg-slate-100 min-h-screen">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">OpenTrack</a>
        </div>
    </nav>

    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card shadow border-0" id="livewire-tracker" data-livewire-component>
                    <div class="card-body">
                        <h2 class="card-title mb-3 text-slate-800">Track any package</h2>
                        <p class="text-muted">Enter a tracking number and the detector will figure out the carrier automatically.</p>
                        <form id="tracking-form" class="space-y-3">
                            <div class="mb-3">
                                <label class="form-label">Tracking number</label>
                                <input type="text" name="tracking_number" class="form-control form-control-lg" placeholder="1Z999AA10123456784" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone for WhatsApp alerts</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+15551234567">
                                <small class="text-muted">Optional. Alerts will be logged locally until you plug in an actual WhatsApp provider.</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">Start tracking</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-4 shadow border-0">
                    <div class="card-body">
                        <h3 class="text-xl font-semibold mb-2">Knowledge base</h3>
                        <p class="text-muted">Carriers embedded offline for demo purposes.</p>
                        <ul class="list-group small">
                            <?php foreach ($carriers as $carrier): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= htmlspecialchars($carrier['name']) ?></span>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($carrier['code']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h2 class="card-title">Live status</h2>
                        <div id="tracking-result" class="text-muted">Submit a tracking number to begin.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/livewire-lite.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>
