const currentPage = 1;

function loadEvents(page = 1) {
    $.ajax({
        url: './components/eventsContainer/eventsCall.php',
        type: 'GET',
        data: {
            page
        },
        success: function(rawResponse) {
            try {
                const response = rawResponse;
                console.log(response);
                const eventGrid = $('#event-grid');
                eventGrid.empty();

                response.events.forEach(event => {
                    const eventCard = `
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">${event.title}</h5>
                            <p class="card-text text-muted">
                                ${event.startDate} - ${event.endDate}
                            </p>
                        </div>
                        <div class="card-body">
                            <p class="card-text">${event.description}</p>
                        </div>
                        <div class="card-footer">
                            <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(event.location)}"
                                class="btn btn-primary" target="_blank">View Location</a>
                        </div>
                    </div>
                </div>`;
                    eventGrid.append(eventCard);
                });

                const pagination = $('#pagination');
                pagination.empty();
                for (let i = 1; i <= response.totalPages; i++) {
                    const activeClass = i === response.currentPage ? 'active' : '';
                    const pageItem = `
                <li class="page-item ${activeClass}">
                    <button class="page-link" onclick="loadEvents(${i})">${i}</button>
                </li>`;
                    pagination.append(pageItem);
                }
            } catch (error) {
                console.error('Parsing error:', error);
                console.log('Raw response:', rawResponse);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response text:', xhr.responseText);
        }
    });
}

$(document).ready(function() {
    loadEvents();
});