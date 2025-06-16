<?php include 'app/view/shares/header.php'; ?>

<h1>Đăng Ký Học Phần</h1>

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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-user-graduate"></i> Chọn Sinh Viên</h5>
            </div>
            <div class="card-body">
                <p>Chọn sinh viên để đăng ký học phần:</p>
                
                <?php if (isset($students) && !empty($students)): ?>
                    <div class="list-group">
                        <?php foreach ($students as $student): ?>
                            <a href="/Ktra/Registration/register/<?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?>" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($student->HoTen, ENT_QUOTES, 'UTF-8'); ?></h6>
                                    <small><?php echo htmlspecialchars($student->MaSV, ENT_QUOTES, 'UTF-8'); ?></small>
                                </div>
                                <p class="mb-1">
                                    <strong>Ngành:</strong> <?php echo htmlspecialchars($student->TenNganh ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                                <small>
                                    <strong>Giới tính:</strong> <?php echo htmlspecialchars($student->GioiTinh, ENT_QUOTES, 'UTF-8'); ?> | 
                                    <strong>Ngày sinh:</strong> <?php echo htmlspecialchars($student->NgaySinh, ENT_QUOTES, 'UTF-8'); ?>
                                </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <p>Chưa có sinh viên nào trong hệ thống.</p>
                        <a href="/Ktra/Product/add" class="btn btn-primary">Thêm Sinh Viên</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5><i class="fas fa-book"></i> Danh Sách Học Phần</h5>
            </div>
            <div class="card-body">
                <p>Tổng số học phần hiện có: <strong><?php echo count($subjects ?? []); ?></strong></p>
                
                <?php if (isset($subjects) && !empty($subjects)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Mã HP</th>
                                    <th>Tên Học Phần</th>
                                    <th>Tín Chỉ</th>
                                    <th>Ngành</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($subjects, 0, 10) as $subject): ?>
                                    <tr>
                                        <td><small><strong><?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?></strong></small></td>
                                        <td><small><?php echo htmlspecialchars($subject->TenHP, ENT_QUOTES, 'UTF-8'); ?></small></td>
                                        <td><small><?php echo htmlspecialchars($subject->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></small></td>
                                        <td><small><?php echo htmlspecialchars($subject->TenNganh ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (count($subjects) > 10): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <small class="text-muted">... và <?php echo count($subjects) - 10; ?> học phần khác</small>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center">
                        <a href="/Ktra/Subject/" class="btn btn-outline-primary btn-sm">Xem Tất Cả Học Phần</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <p>Chưa có học phần nào trong hệ thống.</p>
                        <a href="/Ktra/Subject/add" class="btn btn-primary">Thêm Học Phần</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5><i class="fas fa-info-circle"></i> Hướng Dẫn Sử Dụng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6><i class="fas fa-step-forward"></i> Bước 1: Chọn Sinh Viên</h6>
                        <p>Nhấp vào tên sinh viên bên trái để bắt đầu đăng ký học phần cho sinh viên đó.</p>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-step-forward"></i> Bước 2: Chọn Học Phần</h6>
                        <p>Hệ thống sẽ hiển thị các học phần phù hợp với ngành học của sinh viên.</p>
                    </div>
                    <div class="col-md-4">
                        <h6><i class="fas fa-step-forward"></i> Bước 3: Xác Nhận</h6>
                        <p>Nhấp "Đăng Ký" để hoàn tất. Bạn có thể hủy đăng ký bất cứ lúc nào.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/view/shares/footer.php'; ?>
