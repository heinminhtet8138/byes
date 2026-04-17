<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php'; ?>


<?php

// Real PHP dynamic fetching logic:
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ? AND status = 'Published'");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
}
if (!$post) {
    // Handle 404
}

?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/blog.php">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $post['title'] ?? '10 Tips to Improve Your Speaking Skills'; ?></li>
                </ol>
            </nav>

            <h1 class="fw-bold mb-4"><?php echo $post['title'] ?? '10 Tips to Improve Your Speaking Skills'; ?></h1>
            <div class="d-flex align-items-center mb-5">
                <div class="me-3 rounded-circle d-flex justify-content-center align-items-center bg-light text-dark" style="width: 50px; height: 50px; font-size: 24px;">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div>
                    <div class="fw-bold"><?php echo $post['author_name'] ?? 'Sarah Johnson'; ?></div>
                    <div class="text-muted small"><?php echo isset($post['created_at']) ? date('M d, Y', strtotime($post['created_at'])) : 'April 10, 2026'; ?> • 5 min read</div>
                </div>
            </div>

            <img src="<?php echo $post['image_path'] ?? 'https://picsum.photos/seed/tips/1200/600'; ?>" class="img-fluid rounded-4 mb-5 shadow-sm" alt="Post Banner" referrerPolicy="no-referrer">

            <div class="blog-content text-muted lead" style="line-height: 1.8;">
                <?php if(isset($post['content'])): ?>
                    <?php echo nl2br($post['content']); ?>
                <?php else: ?>
                    <p>Speaking is often considered the most challenging aspect of learning a new language. Unlike writing or reading, speaking happens in real-time, leaving little room for error or hesitation. However, with the right approach, anyone can become a confident English speaker.</p>
                    
                    <h4 class="fw-bold text-dark mt-5 mb-3">1. Don't be afraid to make mistakes</h4>
                    <p>The biggest barrier to speaking is the fear of being wrong. Remember, your goal is communication, not perfection. Most people will understand you even if you make small grammatical errors.</p>
                    
                    <h4 class="fw-bold text-dark mt-5 mb-3">2. Practice every day</h4>
                    <p>Consistency is key. Even 15 minutes of speaking practice daily can make a significant difference over time. Try talking to yourself in the mirror or narrating your daily activities in English.</p>
                    
                    <h4 class="fw-bold text-dark mt-5 mb-3">3. Listen and repeat</h4>
                    <p>Watch English movies or listen to podcasts. When you hear a phrase you like, pause and repeat it out loud. Pay attention to the rhythm and intonation of the speaker.</p>
                    
                    <blockquote class="bg-light p-4 rounded-4 border-start border-primary border-5 my-5 italic">
                        "Language is not a gift, it's a skill that is acquired through practice and persistence."
                    </blockquote>
                    
                    <p>In conclusion, becoming fluent in English takes time and effort, but by following these tips and staying committed, you will see progress sooner than you think.</p>
                <?php endif; ?>
            </div>

            <hr class="my-5">

            <div class="share-section d-flex align-items-center gap-3">
                <span class="fw-bold">Share this post:</span>
                <button class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-facebook"></i></button>
                <button class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-twitter"></i></button>
                <button class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-linkedin"></i></button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
