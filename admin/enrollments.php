<?php 
include 'auth_check.php';
include 'header.php'; 
include '../includes/db_connect.php'; 

// Filter logic အတွက် လက်ရှိရွေးထားတဲ့ status ကိုယူမယ်
$filter = isset($_GET['status']) ? $_GET['status'] : 'All';

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Student Enrollments</h2>
    
    <div class="btn-group shadow-sm p-1 bg-white rounded-3">
        <a href="?status=All" class="btn btn-sm <?php echo $filter == 'All' ? 'btn-primary' : 'btn-light'; ?> rounded-2 px-3">All</a>
        <a href="?status=Pending" class="btn btn-sm <?php echo $filter == 'Pending' ? 'btn-primary' : 'btn-light'; ?> rounded-2 px-3">Pending</a>
        <a href="?status=Approved" class="btn btn-sm <?php echo $filter == 'Approved' ? 'btn-primary' : 'btn-light'; ?> rounded-2 px-3">Approved</a>
        <a href="?status=Declined" class="btn btn-sm <?php echo $filter == 'Declined' ? 'btn-primary' : 'btn-light'; ?> rounded-2 px-3">Declined</a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Student</th>
                        <th>Reg. Date</th> <th>Course</th>
                        <th>Payment Slip</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Filter query ကို dynamic တည်ဆောက်မယ်
                    $sql = "SELECT e.*, c.title as course_title 
                            FROM enrollments e 
                            LEFT JOIN courses c ON e.course_id = c.id";
                    
                    if ($filter != 'All') {
                        $sql .= " WHERE e.status = :status";
                    }
                    $sql .= " ORDER BY e.id DESC";

                    $stmt = $pdo->prepare($sql);
                    if ($filter != 'All') {
                        $stmt->execute(['status' => $filter]);
                    } else {
                        $stmt->execute();
                    }
                    
                    $enrollments = $stmt->fetchAll();

                    foreach ($enrollments as $row):
                        $status_class = [
                            'Pending' => 'bg-warning text-dark',
                            'Approved' => 'bg-success',
                            'Declined' => 'bg-danger'
                        ][$row['status']];

                        // Date format ပြောင်းမယ် (14 April 2026)
                        $reg_date = date('d F Y', strtotime($row['created_at']));
                    ?>
                    <tr id="row-<?php echo $row['id']; ?>">
                        <td class="ps-4">
                            <div class="fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></div>
                            <div class="small text-muted"><?php echo htmlspecialchars($row['student_email']); ?></div>
                        </td>
                        <td class="small"><?php echo $reg_date; ?></td> <td><?php echo htmlspecialchars($row['course_title'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="../uploads/payments/<?php echo $row['payment_slip']; ?>" target="_blank" class="text-primary text-decoration-none small">
                                <i class="bi bi-file-earmark-image"></i> View Slip
                            </a>
                        </td>
                        <td>
                            <span class="badge <?php echo $status_class; ?>" id="badge-<?php echo $row['id']; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td class="pe-4 text-end" id="action-<?php echo $row['id']; ?>">
                            <?php if ($row['status'] == 'Pending'): ?>
                                <button class="btn btn-sm btn-success status-btn" data-id="<?php echo $row['id']; ?>" data-status="Approved">Accept</button>
                                <button class="btn btn-sm btn-outline-danger status-btn" data-id="<?php echo $row['id']; ?>" data-status="Declined">Decline</button>
                            <?php else: ?>
                                <span class="text-muted small"><i class="bi bi-check2-all"></i> Done</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>