<?php 
include 'auth_check.php';

    include '../includes/db_connect.php';
    include 'header.php'; 
    $course = null;
    $is_edit = false;

    // 1. URL မှာ id ပါလာရင် Database ကနေ Fetch လုပ်မယ်
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $course = $stmt->fetch();
        
        if ($course) {
            $is_edit = true;
        }
    }

    // 2. Categories တွေကို Dropdown အတွက် Fetch လုပ်မယ်
    $cat_stmt = $pdo->query("SELECT * FROM categories");
    $categories = $cat_stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold"><?php echo isset($_GET['id']) ? 'Edit' : 'Add New'; ?> Course</h2>
    <a href="manage-courses.php" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to List
    </a>
</div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="course-logic.php" method="POST" enctype="multipart/form-data" id="courseForm">
                    <input type="hidden" name="action" value="<?php echo isset($_GET['id']) ? 'update' : 'create'; ?>">
                    <?php if(isset($_GET['id'])): ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <?php endif; ?>

                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Course Title</label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title" placeholder="e.g. Advanced IELTS Masterclass" required value="<?php echo isset($_GET['id']) ?$course['title'] :''; ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="10" placeholder="Describe the course content, objectives, and target audience..." required><?php echo isset($_GET['id']) ?$course['description'] :''; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <!-- Dynamic categories would be fetched here -->
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo ($is_edit && $course['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo $cat['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label for="price" class="form-label fw-bold">Price ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="199.00" required value="<?php echo isset($_GET['id']) ?$course['price'] :''; ?>">
                                </div>
                                <div class="col-6">
                                    <label for="duration" class="form-label fw-bold">Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g. 8 Weeks" required value="<?php echo isset($_GET['id']) ?$course['duration'] :''; ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="course_image" class="form-label fw-bold">Course Cover Image</label>
                                <div class="image-preview-container mb-3">
                                    <?php if ($is_edit && !empty($course['image_path'])): ?>
                                        <img id="imagePreview" src="../<?php echo $course['image_path']; ?>" width="150" class="img-thumbnail shadow-sm">
                                        <p id="imageStatus" class="small text-muted mt-1">Current Image</p>
                                    <?php else: ?>
                                        <img id="imagePreview" src="#" width="150" class="img-thumbnail shadow-sm d-none">
                                        <p id="imageStatus" class="small text-muted mt-1"></p>
                                    <?php endif; ?>
                                </div>

                                <input class="form-control" type="file" id="course_image" name="course_image" accept="image/jpeg,image/png">
                                <div class="form-text">Allowed formats: JPG, PNG. Max 2MB.</div>
                            </div>

                            <hr class="my-4">
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                <i class="bi bi-check-circle me-2"></i> <?php echo isset($_GET['id']) ? 'Update' : 'Save'; ?> Course
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<script>
$(document).ready(function() {
    // Image Preview logic
    $('#course_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').removeClass('d-none');
                $('#imageStatus').text('New Image Selected').addClass('text-success');
            }
            reader.readAsDataURL(file);
        }
    });

});
</script>

<?php include 'footer.php'; ?>
