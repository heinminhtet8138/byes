<!-- Admin Navigation Sidebar -->
<div class="d-flex flex-column p-3 text-white bg-dark shadow" id="sidebar" style="width: 250px; min-height: 100vh;">
    <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-mortarboard-fill me-2 fs-4"></i>
        <span class="fs-4 fw-bold">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="index.php" class="nav-link text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="enrollments.php" class="nav-link text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'enrollments.php') ? 'active' : ''; ?>">
                <i class="bi bi-people me-2"></i> Enrollments
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="manage-courses.php" class="nav-link text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-courses.php') ? 'active' : ''; ?>">
                <i class="bi bi-book me-2"></i> Manage Courses
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="manage-blogs.php" class="nav-link text-white <?php echo (basename($_SERVER['PHP_SELF']) == 'manage-blogs.php') ? 'active' : ''; ?>">
                <i class="bi bi-file-text me-2"></i> Manage Blogs
            </a>
        </li>
    </ul>
    <hr>
    <div class="mt-auto">
        <a href="logout.php" class="nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
</div>
