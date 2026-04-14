<?php 
include 'auth_check.php';

include '../includes/db_connect.php';    
include 'header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 class="fw-bold">Manage Courses</h2>
    <a href="course-editor.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Add New Course
    </a>
</div>

        <!-- Search and Filter -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="courseSearch" class="form-control border-start-0" placeholder="Search courses by title...">
                </div>
            </div>
            <div class="col-md-4">
                <select id="categoryFilter" class="form-select">
                    <option value="all">All Categories</option>
                    <option value="Basic">Basic</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                </select>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="courseTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Thumbnail</th>
                                <th>Course Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th class="pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Mock Data for UI/UX -->
                             <?php 
                                $sql = "SELECT c.*, cat.name as category_name 
                                FROM courses c 
                                JOIN categories cat ON c.category_id = cat.id 
                                ORDER BY c.created_at DESC";
                                $stmt = $pdo->query($sql);
                                while ($course = $stmt->fetch()) {
                             ?>
                            <tr class="course-row" data-category="<?php echo $course['category_name']; ?>">
                                <td class="ps-4">
                                    <img src="../<?php echo $course['image_path']; ?>" class="rounded shadow-sm" width="100" height="100" alt="Course">
                                </td>
                                <td class="course-title fw-bold"><?php echo $course['title']; ?></td>
                                <td><span class="badge bg-success bg-opacity-10 text-success"><?php echo $course['category_name']; ?></span></td>
                                <td><?php echo $course['price']; ?></td>
                                <td><?php echo $course['duration']; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="course-editor.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn delete-course" data-id="<?php echo $course['id']; ?>"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this course? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete Now</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Search Functionality
    $("#courseSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#courseTable tbody tr").filter(function() {
            $(this).toggle($(this).find(".course-title").text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Category Filter Functionality
    $("#categoryFilter").on("change", function() {
        var category = $(this).val();
        if (category === "all") {
            $(".course-row").show();
        } else {
            $(".course-row").hide();
            $(".course-row[data-category='" + category + "']").show();
        }
    });

// Delete Confirmation
let courseIdToDelete = null;
let rowToDelete = null;

// ၁။ Table ထဲက Delete ခလုတ်ကို နှိပ်တဲ့အခါ
$('.delete-btn').click(function() {
    courseIdToDelete = $(this).data('id'); // Button မှာ data-id="<php echo $course['id']; ?>" ထည့်ထားရမယ်
    rowToDelete = $(this).closest('tr');
    
    // Modal ကို လှမ်းဖွင့်မယ်
    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    myModal.show();
});

// ၂။ Modal ထဲက 'Delete Now' ခလုတ်ကို နှိပ်တဲ့အခါ
$('#confirmDeleteBtn').click(function() {
    $.ajax({
        url: 'course-logic.php',
        method: 'POST',
        data: { action: 'delete_course', id: courseIdToDelete },
        success: function(response) {
            console.log(response);
            
            if (response == 'has_students') {
                alert('ဒီသင်တန်းမှာ ကျောင်းသားစာရင်းရှိနေလို့ ဖျက်ခွင့်မရှိပါဘူး။ အရင်ဆုံး ကျောင်းသားတွေကို ဖယ်ရှားပေးပါ။');
            } else if (response == 'success') {
                $(rowToDelete).fadeOut();
            }
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        }
    });
});
    
});
</script>

<?php include 'footer.php'; ?>
