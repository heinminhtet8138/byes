<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<header class="hero-section py-5 bg-light border-bottom">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">Master English with <span class="text-primary">Confidence</span></h1>
                <p class="lead text-muted mb-5">Join our community of learners and boot your language skills to the next level with expert-led courses and immersive learning experiences.</p>
                <div class="d-flex gap-3">
                    <a href="courses.php" class="btn btn-primary btn-lg px-5">Explore Courses</a>
                    <a href="register.php" class="btn btn-outline-dark btn-lg px-5">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <img src="https://picsum.photos/seed/learning/800/600" alt="Students Learning" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</header>

<section class="features-section py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose Our School?</h2>
            <p class="text-muted">We provide the best environment for your language growth.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="bi bi-person-check fs-1 text-primary mb-3"></i>
                    <h4 class="fw-bold">Expert Teachers</h4>
                    <p class="text-muted">Learn from native speakers and certified professionals.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="bi bi-laptop fs-1 text-primary mb-3"></i>
                    <h4 class="fw-bold">Flexible Learning</h4>
                    <p class="text-muted">Access our courses online or in-person with flexible schedules.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="bi bi-award fs-1 text-primary mb-3"></i>
                    <h4 class="fw-bold">Certified Results</h4>
                    <p class="text-muted">Get recognized certificates that help your career journey.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="courses-section py-5 bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold">Popular Courses</h2>
                <p class="text-muted mb-0">Elevate your skills with our most enrolled programs.</p>
            </div>
            <a href="courses.php" class="btn btn-outline-primary rounded-pill px-4">View All Courses</a>
        </div>
        <div class="row g-4">
            <?php
            $course_stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC LIMIT 3");
            while ($course = $course_stmt->fetch()):
            ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo $course['image_path']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($course['title']); ?></h5>
                        <div class="mb-3">
                            <span class="text-primary fw-bold fs-5">$<?php echo number_format($course['price'], 2); ?></span>
                        </div>
                        <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary w-100 rounded-pill">Enroll Now</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="blog-section py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Latest Knowledge & Tips</h2>
            <p class="text-muted">Stay updated with our educational insights.</p>
        </div>
        <div class="row g-4">
            <?php
            $blog_stmt = $pdo->query("SELECT * FROM blog_posts WHERE status = 'Published' ORDER BY created_at DESC LIMIT 3");
            while ($post = $blog_stmt->fetch()):
            ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo $post['image_path']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2"><?php echo htmlspecialchars($post['category']); ?></span>
                        <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <a href="post-detail.php?id=<?php echo $post['id']; ?>" class="text-primary fw-bold text-decoration-none small">Read More <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="cta-section py-5 bg-primary text-white text-center">
    <div class="container py-5">
        <h2 class="display-5 fw-bold mb-4">Ready to start your journey?</h2>
        <p class="lead mb-5 opacity-75">Enroll today and get a 20% discount on your first course.</p>
        <a href="register.php" class="btn btn-light btn-lg px-5 text-primary fw-bold rounded-pill">Register Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>