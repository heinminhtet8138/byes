<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php' ?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="fw-bold mb-3">Our English Courses</h1>
            <p class="text-muted lead">Find the perfect course for your level and goals.</p>
        </div>
    </div>

    <!-- Category Filter -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">All Levels</button>
                <button type="button" class="btn btn-outline-primary" data-filter="basic">Basic</button>
                <button type="button" class="btn btn-outline-primary" data-filter="intermediate">Intermediate</button>
                <button type="button" class="btn btn-outline-primary" data-filter="advanced">Advanced</button>
            </div>
        </div>
    </div>

    <div class="row g-4" id="course-grid">
        <?php
        
        // Real PHP dynamic fetching logic:
        $sql = "SELECT c.*, cat.name as category_name 
                FROM courses c 
                JOIN categories cat ON c.category_id = cat.id 
                ORDER BY c.created_at DESC";
        $stmt = $pdo->query($sql);
        while ($course = $stmt->fetch()) {
        ?>
        <div class="col-md-4 course-item" data-category="<?php echo strtolower($course['category_name']); ?>">
            <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-4">
                <img src="<?php echo $course['image_path']; ?>" class="card-img-top" alt="<?php echo $course['title']; ?>">
                <div class="card-body p-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2"><?php echo $course['category_name']; ?></span>
                    <h5 class="card-title fw-bold"><?php echo $course['title']; ?></h5>
                    <p class="card-text text-muted"><?php echo substr($course['description'], 0, 100); ?>...</p>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="fw-bold text-primary fs-5">$<?php echo number_format($course['price'], 2); ?></span>
                        <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <?php }  ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-group button').click(function() {
        const filter = $(this).data('filter');
        $('.btn-group button').removeClass('active');
        $(this).addClass('active');

        if (filter === 'all') {
            $('.course-item').fadeIn();
        } else {
            $('.course-item').hide();
            $('.course-item[data-category="' + filter + '"]').fadeIn();
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
