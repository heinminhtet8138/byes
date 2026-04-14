<?php 
include 'auth_check.php';

    include '../includes/db_connect.php';
    include 'header.php'; 
    $blog = null;
    $is_edit = false;

    // 1. URL မှာ id ပါလာရင် Database ကနေ Fetch လုပ်မယ်
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
        
        if ($blog) {
            $is_edit = true;
        }
    }

    // 2. Categories တွေကို Blog Posts table ထဲက ရှိပြီးသားတွေ ယူမယ် (သို့မဟုတ် လက်ရိုက်ထည့်လို့ရအောင် ထားမယ်)
    $cat_query = $pdo->query("SELECT DISTINCT category FROM blog_posts WHERE category IS NOT NULL");
    $categories = $cat_query->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold"><?php echo $is_edit ? 'Edit' : 'Add New'; ?> Blog Post</h2>
    <a href="manage-blogs.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to List
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-5">
        <form action="blog-logic.php" method="POST" enctype="multipart/form-data" id="blogForm">
            <input type="hidden" name="action" value="<?php echo $is_edit ? 'update' : 'create'; ?>">
            <?php if($is_edit): ?>
                <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Blog Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" placeholder="Enter blog title here..." required value="<?php echo $is_edit ? htmlspecialchars($blog['title']) : ''; ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Blog Content</label>
                        <textarea class="form-control" id="content" name="content" rows="15" placeholder="Write your blog post content here..." required><?php echo $is_edit ? htmlspecialchars($blog['content']) : ''; ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-4">
                        <label for="category" class="form-label fw-bold">Category</label>
                        <input type="text" class="form-control" name="category" list="categoryOptions" placeholder="e.g. Grammar, Tips" required value="<?php echo $is_edit ? htmlspecialchars($blog['category']) : ''; ?>">
                        <datalist id="categoryOptions">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    
                    <div class="mb-4">
                        <label for="author_name" class="form-label fw-bold">Author Name</label>
                        <input type="text" class="form-control" id="author_name" name="author_name" required value="<?php echo $is_edit ? htmlspecialchars($blog['author_name']) : 'Admin'; ?>">
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Published" <?php echo ($is_edit && $blog['status'] == 'Published') ? 'selected' : ''; ?>>Published</option>
                            <option value="Draft" <?php echo ($is_edit && $blog['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="blog_image" class="form-label fw-bold">Blog Cover Image</label>
                        <div class="image-preview-container mb-3">
                            <?php if ($is_edit && !empty($blog['image_path'])): ?>
                                <img id="imagePreview" src="../<?php echo $blog['image_path']; ?>" width="150" class="img-thumbnail shadow-sm">
                                <p id="imageStatus" class="small text-muted mt-1">Current Image</p>
                            <?php else: ?>
                                <img id="imagePreview" src="#" width="150" class="img-thumbnail shadow-sm d-none">
                                <p id="imageStatus" class="small text-muted mt-1"></p>
                            <?php endif; ?>
                        </div>

                        <input class="form-control" type="file" id="blog_image" name="blog_image" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Formats: JPG, PNG, WEBP. Max 2MB.</div>
                    </div>

                    <hr class="my-4">
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> <?php echo $is_edit ? 'Update' : 'Publish'; ?> Post
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Image Preview logic
    $('#blog_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').removeClass('d-none');
                $('#imageStatus').text('New Image Selected').removeClass('text-muted').addClass('text-success');
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?php include 'footer.php'; ?>