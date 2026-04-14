<?php 
include 'auth_check.php';
include '../includes/db_connect.php';    
include 'header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold">Manage Blog Posts</h2>
    <a href="blog-editor.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Add New Post
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" id="blogSearch" class="form-control border-start-0" placeholder="Search blogs by title...">
        </div>
    </div>
    <div class="col-md-4">
        <select id="blogCategoryFilter" class="form-select">
            <option value="all">All Categories</option>
            <?php 
                // ရှိသမျှ Category တွေကို DB ကနေ ဆွဲထုတ်မယ်
                $cat_stmt = $pdo->query("SELECT DISTINCT category FROM blog_posts WHERE category IS NOT NULL");
                while($c = $cat_stmt->fetch()) {
                    echo '<option value="'.$c['category'].'">'.$c['category'].'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="blogTable">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Thumbnail</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
                        $stmt = $pdo->query($sql);
                        while ($blog = $stmt->fetch()) {
                    ?>
                    <tr class="blog-row" data-category="<?php echo $blog['category']; ?>">
                        <td class="ps-4">
                            <img src="../<?php echo $blog['image_path']; ?>" class="rounded shadow-sm" width="100" height="60" style="object-fit: cover;" alt="Blog">
                        </td>
                        <td class="blog-title fw-bold"><?php echo $blog['title']; ?></td>
                        <td><?php echo $blog['author_name']; ?></td>
                        <td>
                            <span class="badge <?php echo ($blog['status'] == 'Published') ? 'bg-success' : 'bg-secondary'; ?> bg-opacity-10 <?php echo ($blog['status'] == 'Published') ? 'text-success' : 'text-secondary'; ?>">
                                <?php echo $blog['status']; ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($blog['created_at'])); ?></td>
                        <td class="pe-4 text-end">
                            <a href="blog-editor.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                            <button class="btn btn-sm btn-outline-danger delete-blog-btn" data-id="<?php echo $blog['id']; ?>"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this blog post? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBlogBtn" class="btn btn-danger">Delete Now</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // ၁။ Search Functionality (Title နဲ့ ရှာမယ်)
    $("#blogSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#blogTable tbody tr").filter(function() {
            $(this).toggle($(this).find(".blog-title").text().toLowerCase().indexOf(value) > -1)
        });
    });

    // ၂။ Category Filter Functionality
    $("#blogCategoryFilter").on("change", function() {
        var category = $(this).val();
        if (category === "all") {
            $(".blog-row").show();
        } else {
            $(".blog-row").hide();
            $(".blog-row[data-category='" + category + "']").show();
        }
    });

    // ၃။ Delete Logic
    let blogIdToDelete = null;
    let rowToDelete = null;

    $('.delete-blog-btn').click(function() {
        blogIdToDelete = $(this).data('id');
        rowToDelete = $(this).closest('tr');
        var myModal = new bootstrap.Modal(document.getElementById('deleteBlogModal'));
        myModal.show();
    });

    $('#confirmDeleteBlogBtn').click(function() {
        $.ajax({
            url: 'blog-logic.php',
            method: 'POST',
            data: { action: 'delete', id: blogIdToDelete },
            success: function(response) {
                if (response.trim() == 'success') {
                    $(rowToDelete).fadeOut();
                    bootstrap.Modal.getInstance(document.getElementById('deleteBlogModal')).hide();
                } else {
                    alert('Error: ' + response);
                }
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>