<?php
/**
 * Admin Dashboard - Final Implementation with Correct DB Path
 */
include 'auth_check.php';
// Database Path ကို CEO ပေးတဲ့အတိုင်း ပြင်ထားပါတယ်
include '../includes/db_connect.php'; 

// --- DATABASE LOGIC ---
try {
    // ၁။ Card Stats များအတွက် အရေအတွက်တွက်ချက်ခြင်း
    $total_courses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    
    // Approved ဖြစ်ပြီးသား ကျောင်းသားရင်း
    $total_students = $pdo->query("SELECT COUNT(*) FROM enrollments WHERE status = 'Approved'")->fetchColumn();
    
    // Pending ဖြစ်နေတဲ့ အပ်နှံမှုများ
    $pending_count = $pdo->query("SELECT COUNT(*) FROM enrollments WHERE status = 'Pending'")->fetchColumn();
    
    // Blog Posts အရေအတွက်
    $total_blogs = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();

    // ၂။ Recent Enrollments (နောက်ဆုံးအပ်ထားတဲ့ ၅ ယောက်စာရင်း)
    $recent_query = "SELECT e.*, c.title as course_title 
                     FROM enrollments e 
                     LEFT JOIN courses c ON e.course_id = c.id 
                     ORDER BY e.id DESC LIMIT 5";
    $recent_enrollments = $pdo->query($recent_query)->fetchAll();

} catch (PDOException $e) {
    // Database ချိတ်ဆက်မှု Error တက်ရင် ဒီမှာပြမယ်
    die("<div class='alert alert-danger'>Database Connection Error: " . $e->getMessage() . "</div>");
}

include 'header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Dashboard Overview</h2>
    <div class="badge bg-light text-dark shadow-sm p-2 px-3 border">
        <i class="bi bi-calendar3 me-2"></i><?php echo date('l, F j, Y'); ?>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card bg-primary text-white border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-journal-bookmark-fill fs-1 mb-2"></i>
                <h6 class="card-title opacity-75">Total Courses</h6>
                <h2 class="display-6 fw-bold"><?php echo number_format($total_courses); ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-people-fill fs-1 mb-2"></i>
                <h6 class="card-title opacity-75">Total Students</h6>
                <h2 class="display-6 fw-bold"><?php echo number_format($total_students); ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-dark border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-clock-history fs-1 mb-2"></i>
                <h6 class="card-title opacity-75">Pending</h6>
                <h2 class="display-6 fw-bold"><?php echo number_format($pending_count); ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-chat-left-text-fill fs-1 mb-2"></i>
                <h6 class="card-title opacity-75">Blog Posts</h6>
                <h2 class="display-6 fw-bold"><?php echo number_format($total_blogs); ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge me-2 text-primary"></i>Recent Enrollments</h5>
                <a href="enrollments.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All List</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Student Info</th>
                                <th>Course</th>
                                <th>Reg. Date</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($recent_enrollments) > 0): ?>
                                <?php foreach ($recent_enrollments as $row): 
                                    $status_badge = [
                                        'Pending' => 'bg-warning text-dark',
                                        'Approved' => 'bg-success',
                                        'Declined' => 'bg-danger'
                                    ][$row['status']];
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></div>
                                        <div class="small text-muted"><?php echo htmlspecialchars($row['student_email']); ?></div>
                                    </td>
                                    <td><span class="text-truncate d-inline-block" style="max-width: 150px;"><?php echo htmlspecialchars($row['course_title'] ?? 'N/A'); ?></span></td>
                                    <td class="small"><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                    <td><span class="badge <?php echo $status_badge; ?>"><?php echo $row['status']; ?></span></td>
                                    <td class="pe-4 text-end">
                                        <a href="enrollments.php" class="btn btn-sm btn-light border shadow-sm">Review</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder2-open fs-2 d-block mb-2"></i>
                                        No recent enrollments found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>