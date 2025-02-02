<!DOCTYPE html>
<html lang="en">

<?php
    include "./common/headers/index.php";
    phphead(
        $title= "EventFlow - Event Management System",
        $description= "Create, manage, and track events efficiently with our comprehensive event management system.",
        $keywords= "event management, event planning, event scheduling, event tracking, event registration, event management software, event management platform, event management system, event management tools, event management services, event management solutions, event management software, event management platform, event management system, event management tools, event management services, event management solutions",
    )
?>
<body>

<?php
    include_once "./common/components/navbar.php";
?>

    <header class="bg-light py-5">
        <div class="container">
            <div class="align-items-center row">
                <div class="col-lg-6">
                    <h1 class="fw-bold display-4">Manage Your Events with Ease</h1>
                    <p class="text-muted lead">Create, manage, and track events efficiently with our comprehensive event management system.</p>
                    <div class="d-md-flex justify-content-md-start gap-2 d-grid">
                        <button class="px-4 btn btn-lg btn-primary me-md-2"><i class="fa-plus-circle fas me-2"></i>Create Event</button>
                        <button class="px-4 btn btn-lg btn-outline-primary"><i class="fa-search fas me-2"></i>Browse Events</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="./common/assets/cover_vertical.webp" alt="Event Management" class="shadow rounded img-fluid">
                </div>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <h2 class="mb-5 text-center">Key Features</h2>
            <div class="g-4 row">
                <div class="col-md-4">
                    <div class="shadow-sm h-100 card">
                        <div class="text-center card-body">
                            <i class="mb-3 text-primary fa-3x fa-calendar-plus fas"></i>
                            <h5 class="card-title">Event Creation</h5>
                            <p class="card-text">Create and customize events with detailed information, capacity limits, and registration options.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm h-100 card">
                        <div class="text-center card-body">
                            <i class="mb-3 text-primary fa-3x fa-users fas"></i>
                            <h5 class="card-title">Attendee Management</h5>
                            <p class="card-text">Track registrations, manage attendee lists, and generate detailed reports.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm h-100 card">
                        <div class="text-center card-body">
                            <i class="mb-3 text-primary fa-3x fa-chart-line fas"></i>
                            <h5 class="card-title">Analytics & Reports</h5>
                            <p class="card-text">Access event statistics and download comprehensive reports in CSV format.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <h2 class="mb-5 text-center">Recent Events</h2>
            <div class="g-4 row">
                <div class="col-lg-4 col-md-6">
                    <div class="shadow-sm h-100 card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Event 1">
                        <div class="card-body">
                            <h5 class="card-title">Tech Conference 2025</h5>
                            <p class="card-text">Join us for the biggest tech conference of the year.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fa-calendar-day fas me-2"></i>Mar 15, 2025</small>
                                <button class="btn btn-primary btn-sm">Register Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="shadow-sm h-100 card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Event 2">
                        <div class="card-body">
                            <h5 class="card-title">Music Festival</h5>
                            <p class="card-text">Experience the best musical performances live.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fa-calendar-day fas me-2"></i>Apr 20, 2025</small>
                                <button class="btn btn-primary btn-sm">Register Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="shadow-sm h-100 card">
                        <img src="/api/placeholder/400/200" class="card-img-top" alt="Event 3">
                        <div class="card-body">
                            <h5 class="card-title">Business Summit</h5>
                            <p class="card-text">Network with industry leaders and experts.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fa-calendar-day fas me-2"></i>May 10, 2025</small>
                                <button class="btn btn-primary btn-sm">Register Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark py-4 text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fa-calendar-alt fas me-2"></i>EventFlow</h5>
                    <p>Your complete event management solution</p>
                </div>
                <div class="text-md-end col-md-6">
                    <div class="mb-2">
                        <a href="#" class="text-light me-3"><i class="fa-facebook fab"></i></a>
                        <a href="#" class="text-light me-3"><i class="fa-twitter fab"></i></a>
                        <a href="#" class="text-light"><i class="fa-instagram fab"></i></a>
                    </div>
                    <small>&copy; 2025 EventFlow. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>