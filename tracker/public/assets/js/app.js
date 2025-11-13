$(function () {
    const result = $('#tracking-result');
    const component = document.querySelector('#livewire-tracker');

    function renderEvents(payload) {
        if (!payload.carrier) {
            result.html('<div class="alert alert-warning">' + (payload.message || 'Carrier not found') + '</div>');
            return;
        }
        let html = `<div class="mb-3">
            <span class="badge bg-primary">${payload.carrier}</span>
            <span class="badge bg-light text-dark ms-2">${payload.tracking_number}</span>
            <div class="text-muted small">Last sync: ${payload.last_sync}</div>
        </div>`;
        html += '<div class="timeline">';
        payload.events.forEach((event) => {
            html += `<div class="event-item">
                <div class="fw-bold">${event.status}</div>
                <div>${event.description}</div>
                <div class="text-muted small">${event.location} • ${event.timestamp}</div>
            </div>`;
        });
        html += '</div>';
        result.html(html);
    }

    $('#tracking-form').on('submit', function (e) {
        e.preventDefault();
        const trackingNumber = $(this).find('[name="tracking_number"]').val();
        const phone = $(this).find('[name="phone"]').val();
        result.html('<div class="spinner-border text-primary" role="status"></div>');
        $.get('/api/track', { tracking_number: trackingNumber })
            .done((data) => {
                renderEvents(data);
                if (phone) {
                    $.ajax({
                        url: '/api/whatsapp/send',
                        method: 'POST',
                        data: JSON.stringify({
                            phone,
                            message: `Tracking update for ${trackingNumber}`,
                            tracking_number: trackingNumber,
                            snapshot: data
                        }),
                        contentType: 'application/json'
                    });
                }
                component.__livewire?.emit('tracking:updated', data);
            })
            .fail(() => {
                result.html('<div class="alert alert-danger">Unable to fetch tracking information.</div>');
            });
    });
});
