<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<?php

// Real PHP dynamic fetching logic:
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT c.*, cat.name as category_name 
            FROM courses c 
            JOIN categories cat ON c.category_id = cat.id 
            WHERE c.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $course = $stmt->fetch();
}
if (!$course) {
    // Handle 404 or redirect
}

?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="courses.php">Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $course['title'] ?? 'IELTS Preparation'; ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <img src="<?php echo $course['image_path'] ?? 'https://picsum.photos/seed/advanced/1200/600'; ?>" class="img-fluid rounded-4 mb-4 shadow-sm" alt="Course Banner" referrerPolicy="no-referrer">
            <h1 class="fw-bold mb-3"><?php echo $course['title'] ?? 'IELTS Preparation Masterclass'; ?></h1>
            <div class="d-flex gap-3 mb-4">
                <span class="badge bg-danger"><?php echo $course['category_name'] ?? 'Advanced'; ?></span>
                <span class="text-muted"><i class="bi bi-clock"></i> <?php echo $course['duration'] ?? '12 Weeks'; ?></span>
                <span class="text-muted"><i class="bi bi-people"></i> 15 Students Max</span>
            </div>
            
            <h4 class="fw-bold mb-3">Course Description</h4>
            <div class="text-muted lead mb-5">
                <?php if(isset($course['description'])): ?>
                    <?php echo nl2br($course['description']); ?>
                <?php else: ?>
                    <p>This course is designed for students who are planning to take the IELTS Academic or General Training exam. We provide comprehensive strategies for each section of the test.</p>
                <?php endif; ?>
            </div>
            
            
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold text-primary mb-4"><?php echo $course['price'].' Ks' ?? '350000 Ks'; ?></h3>
                    <a href="register.php?course_id=<?php echo $course['id']?>" class="btn btn-primary btn-lg w-100 mb-3">Register Now</a>
                    <p class="small text-muted mb-0">Secure your spot today. Limited seats available for the next intake.</p>
                    <hr>
                    <div class="text-start">
                        <h6 class="fw-bold mb-3">This course includes:</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><i class="bi bi-journal-text me-2"></i> Study Materials</li>
                            <li class="mb-2"><i class="bi bi-headset me-2"></i> 24/7 Support</li>
                            <li class="mb-2"><i class="bi bi-award me-2"></i> Certificate of Completion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
