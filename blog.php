<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="fw-bold mb-3">English Learning Blog</h1>
            <p class="text-muted lead">Tips, tricks, and articles to help you master the English language.</p>
        </div>
    </div>

    <div class="row g-4">
        <?php
        
        // Real PHP dynamic fetching logic:
        $stmt = $pdo->query("SELECT * FROM blog_posts WHERE status = 'Published' ORDER BY created_at DESC");
        while ($post = $stmt->fetch()) {
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="<?php echo $post['image_path']; ?>" class="card-img-top" alt="Blog Post">
                <div class="card-body p-4">
                    <div class="text-muted small mb-2"><?php echo date('M d, Y', strtotime($post['created_at'])); ?> • 5 min read</div>
                    <h5 class="card-title fw-bold"><?php echo $post['title']; ?></h5>
                    <p class="card-text text-muted"><?php echo substr(strip_tags($post['content']), 0, 100); ?>...</p>
                    <a href="post-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-link text-primary p-0 fw-bold text-decoration-none">Read More <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>


<?php include 'includes/footer.php'; ?>
