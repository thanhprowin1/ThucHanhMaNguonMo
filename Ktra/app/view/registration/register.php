<?php include 'app/view/shares/header.php'; ?>

<h1>Đăng Ký Học Phần - <?php echo htmlspecialchars($student->HoTen, ENT_QUOTES, 'UTF-8'); ?></h1>

<!-- Hiển thị thông báo -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Thông tin sinh viên -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-user"></i> Thông Tin Sinh Viên</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($student->HoTen, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($student->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($student->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Tổng tín chỉ đã đăng ký:</strong> 
                    <span class="badge badge-info"><?php echo $totalCredits; ?> tín chỉ</span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Cột trái: Học phần có thể đăng ký -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5><i class="fas fa-plus-circle"></i> Học Phần Có Thể Đăng Ký</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($subjects)): ?>
                    <?php foreach ($subjects as $subject): ?>
                        <?php 
                        $isRegistered = false;
                        foreach ($registeredSubjects as $registered) {
                            if ($registered->MaHP === $subject->MaHP) {
                                $isRegistered = true;
                                break;
                            }
                        }
                        ?>
                        
                        <?php if (!$isRegistered): ?>
                            <div class="card mb-2">
                                <div class="card-body p-3">
                                    <h6 class="card-title"><?php echo htmlspecialchars($subject->TenHP, ENT_QUOTES, 'UTF-8'); ?></h6>
                                    <p class="card-text">
                                        <small>
                                            <strong>Mã:</strong> <?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?> | 
                                            <strong>Tín chỉ:</strong> <?php echo htmlspecialchars($subject->SoTinChi, ENT_QUOTES, 'UTF-8'); ?>
                                        </small>
                                    </p>
                                    <form method="POST" action="/Ktra/Registration/doRegister" style="display: inline;">
                                        <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="maHP" value="<?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i> Đăng Ký
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php 
                    $availableSubjects = 0;
                    foreach ($subjects as $subject) {
                        $isRegistered = false;
                        foreach ($registeredSubjects as $registered) {
                            if ($registered->MaHP === $subject->MaHP) {
                                $isRegistered = true;
                                break;
                            }
                        }
                        if (!$isRegistered) $availableSubjects++;
                    }
                    ?>
                    
                    <?php if ($availableSubjects === 0): ?>
                        <div class="alert alert-info">
                            <p>Bạn đã đăng ký tất cả học phần của ngành này!</p>
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <div class="alert alert-warning">
                        <p>Không có học phần nào cho ngành học này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Cột phải: Học phần đã đăng ký -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5><i class="fas fa-list"></i> Học Phần Đã Đăng Ký</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($registeredSubjects)): ?>
                    <?php foreach ($registeredSubjects as $registered): ?>
                        <div class="card mb-2">
                            <div class="card-body p-3">
                                <h6 class="card-title"><?php echo htmlspecialchars($registered->TenHP, ENT_QUOTES, 'UTF-8'); ?></h6>
                                <p class="card-text">
                                    <small>
                                        <strong>Mã:</strong> <?php echo htmlspecialchars($registered->MaHP, ENT_QUOTES, 'UTF-8'); ?> | 
                                        <strong>Tín chỉ:</strong> <?php echo htmlspecialchars($registered->SoTinChi, ENT_QUOTES, 'UTF-8'); ?><br>
                                        <strong>Ngày đăng ký:</strong> <?php echo htmlspecialchars($registered->NgayDangKy, ENT_QUOTES, 'UTF-8'); ?>
                                    </small>
                                </p>
                                <form method="POST" action="/Ktra/Registration/unregister" style="display: inline;">
                                    <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="maHP" value="<?php echo htmlspecialchars($registered->MaHP, ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký học phần này?');">
                                        <i class="fas fa-times"></i> Hủy Đăng Ký
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>Chưa đăng ký học phần nào.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="/Ktra/Registration/" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
    <a href="/Ktra/Product/" class="btn btn-info">
        <i class="fas fa-users"></i> Danh sách Sinh viên
    </a>
</div>

<?php include 'app/view/shares/footer.php'; ?>
