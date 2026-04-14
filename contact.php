<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container py-5">
    <div class="row mb-5 py-4">
        <div class="col-lg-8 mx-auto text-center">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3">Reach Out to Us</span>
            <h1 class="display-4 fw-bold mb-3">Get in <span class="text-primary">Touch</span></h1>
            <p class="text-muted lead">Have any questions about our courses or enrollment? We are here to help you every step of the way on your language learning journey.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-top transition">
                <div class="bg-primary bg-opacity-10 p-4 rounded-circle mx-auto mb-4" style="width: fit-content;">
                    <i class="bi bi-chat-dots text-primary fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Live Chat</h4>
                <p class="text-muted small mb-4">Chat with our support team via Facebook Messenger for instant answers to your inquiries.</p>
                <a href="https://m.me/yourpage" target="_blank" class="btn btn-outline-primary rounded-pill w-100 fw-bold">
                    <i class="bi bi-facebook me-2"></i> Message Us
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-top transition">
                <div class="bg-success bg-opacity-10 p-4 rounded-circle mx-auto mb-4" style="width: fit-content;">
                    <i class="bi bi-telephone text-success fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Call Support</h4>
                <p class="text-muted small mb-4">Prefer a direct conversation? Call us during office hours to discuss your learning goals.</p>
                <div class="fw-bold text-dark">+95 9 123 456 789</div>
                <div class="fw-bold text-dark mb-3">+95 9 987 654 321</div>
                <a href="tel:+959123456789" class="btn btn-success rounded-pill w-100 fw-bold">
                    <i class="bi bi-telephone-outbound me-2"></i> Call Now
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center hover-top transition">
                <div class="bg-info bg-opacity-10 p-4 rounded-circle mx-auto mb-4" style="width: fit-content;">
                    <i class="bi bi-geo-alt text-info fs-1"></i>
                </div>
                <h4 class="fw-bold mb-2">Visit Campus</h4>
                <p class="text-muted small mb-4">Visit our learning center to experience our environment and meet our instructors in person.</p>
                <p class="small text-muted mb-3">No. 123, Education St, Yangon, Myanmar</p>
                <a href="#map" class="btn btn-outline-info rounded-pill w-100 fw-bold">
                    <i class="bi bi-map me-2"></i> Get Directions
                </a>
            </div>
        </div>
    </div>

    <div class="row pt-5" id="map">
        <div class="col-12 text-center mb-4">
            <h3 class="fw-bold">Find Us on the Map</h3>
        </div>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.123456789!2d96.1234567!3d16.1234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDA3JzM0LjUiTiA5NsKwMDcnMjQuNCJF!5e0!3m2!1sen!2smm!4v1234567890" 
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Professional Hover Effects */
    .hover-top {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-top:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.08) !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
    #map iframe {
        filter: grayscale(20%); /* Optional: Adds a modern touch to the map */
    }
</style>

<?php include 'includes/footer.php'; ?>