<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php 
    include 'includes/db_connect.php';
    // ၁။ URL ကနေ ပါလာတဲ့ course_id ကို ဖမ်းမယ် (ဥပမာ: registration.php?course_id=5)
    $selected_course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';

    // ၂။ DB ထဲက Active ဖြစ်နေတဲ့ Course အားလုံးကို ဆွဲထုတ်မယ်
    $stmt = $pdo->query("SELECT id, title FROM courses");
    $courses = $stmt->fetchAll();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <h2 class="fw-bold mb-0">Course Registration</h2>
                    <p class="mb-0 opacity-75">Fill in the details to enroll in your course</p>
                </div>
                <div class="card-body p-5">
                    <form id="registrationForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. 09 234 567 890" required>
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label fw-bold">Select Course</label>
                            <select class="form-select" id="course" name="course_id" required>
                                <option value="" disabled <?php echo empty($selected_course_id) ? 'selected' : ''; ?>>Choose a course...</option>
                                
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?php echo $c['id']; ?>" 
                                        <?php echo ($selected_course_id == $c['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($c['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                                
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_slip" class="form-label fw-bold">Payment Slip (Image)</label>
                            <div class="image-preview-container mb-3">
                                <img id="imagePreview" src="#" width="150" class="img-thumbnail shadow-sm d-none">
                                <input class="form-control" type="file" id="payment_slip" name="payment_slip" accept="image/*" required>
                                <div class="form-text">Please upload a clear photo or PDF of your bank transfer receipt.</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">Submit Registration</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- success modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Registration Successful!</h5>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
        <p class="mt-3">သင်တန်းအပ်နှံမှု အောင်မြင်ပါသည်။ ခဏတာ စောင့်ဆိုင်းပေးပါ။</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="goToIndexBtn" class="btn btn-success w-100">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Image Preview logic
    $('#payment_slip').change(function() {
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


    $('#registrationForm').submit(function(e) {
        e.preventDefault();
        
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Processing...');

        let formData = new FormData(this);

        $.ajax({
            url: 'register-logic.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                const res = response.trim();
                console.log("Server Response:", res); // ဒီနေရာမှာ ဘာပေါ်လဲ Console မှာ ကြည့်ပါ

                if (res === 'success') {
                    // အောင်မြင်မှ Modal ပြမယ်
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                    
                    $('#goToIndexBtn').click(function() {
                        window.location.href = 'index.php';
                    });
                } else {
                    // Error တစ်ခုခု လာရင် Modal မပြဘဲ Alert ပြမယ်
                    alert('Registration မအောင်မြင်ပါ- ' + res);
                    submitBtn.prop('disabled', false).text('Submit Registration');
                }
            },
            error: function(xhr, status, error) {
                alert('Server Error: ' + error);
                submitBtn.prop('disabled', false).text('Submit Registration');
            }
        });
    });

});
</script>

<?php include 'includes/footer.php'; ?>
