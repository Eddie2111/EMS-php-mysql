let currentSort = { field: 'startDate', direction: 'asc' };

// Create sort buttons container only once
function createSortButtons() {
    // Remove existing sort buttons if they exist
    $('#sort-buttons').remove();

    return `
        <div id="sort-buttons" class="mb-3">
            <div class="btn-group">
                <button class="btn btn-outline-secondary" onclick="toggleSort('title')">
                    Sort by Title ${getSortIcon('title')}
                </button>
                <button class="btn btn-outline-secondary" onclick="toggleSort('startDate')">
                    Sort by Start Date ${getSortIcon('startDate')}
                </button>
            </div>
        </div>`;
}

function updateURL(page, sortField, sortDirection) {
    const params = new URLSearchParams();
    params.set('page', page);
    params.set('sort', sortField);
    params.set('direction', sortDirection);
    const newURL = `${window.location.pathname}?${params.toString()}`;
    window.history.pushState({ page, sort: sortField, direction: sortDirection }, '', newURL);
}

function getParamsFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return {
        page: parseInt(urlParams.get('page')) || 1,
        sort: urlParams.get('sort') || 'startDate',
        direction: urlParams.get('direction') || 'asc'
    };
}

function toggleSort(field) {
    if (currentSort.field === field) {
        currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
    } else {
        currentSort.field = field;
        currentSort.direction = 'asc';
    }
    loadEvents(1); // Reset to first page when sorting
}

function getSortIcon(field) {
    if (currentSort.field !== field) return '↕️';
    return currentSort.direction === 'asc' ? '↑' : '↓';
}

function loadEvents(page = getParamsFromURL().page) {
    $.ajax({
        url: './components/eventsContainer/eventsCall.php',
        type: 'GET',
        data: {
            page: page,
            sort: currentSort.field,
            direction: currentSort.direction
        },
        success: function (response) {
            try {
                updateURL(page, currentSort.field, currentSort.direction);

                const eventGrid = $('#event-grid');
                const container = eventGrid.parent();

                // Add sort buttons before the grid if they don't exist
                if ($('#sort-buttons').length === 0) {
                    container.prepend(createSortButtons());
                }

                eventGrid.empty();

                response.events.forEach(event => {
                    const eventCard = `
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">${event.title}</h5>
                                    <p class="card-text text-muted">
                                        starts at: ${event.startDate}
                                    </p>
                                    <p class="card-text text-muted">
                                        ends at: ${event.endDate}
                                    </p>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">${event.description}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="/dashboard/event?id=${event.id}"
                                        class="btn btn-primary" target="_blank">Learn More</a>
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
                console.error('Error:', error);
                console.log('Response:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response text:', xhr.responseText);
        }
    });
}

window.addEventListener('popstate', function (event) {
    if (event.state) {
        currentSort.field = event.state.sort || 'startDate';
        currentSort.direction = event.state.direction || 'asc';
        loadEvents(event.state.page || 1);
    } else {
        loadEvents(1);
    }
});

$(document).ready(function () {
    const params = getParamsFromURL();
    currentSort.field = params.sort;
    currentSort.direction = params.direction;
    loadEvents();
});