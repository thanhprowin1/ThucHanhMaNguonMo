<?php include 'app/view/shares/header.php'; ?>

<h1>Chi Tiết Sinh Viên</h1>

<?php if (isset($product) && $product): ?>
    <div class="card">
        <div class="card-header">
            <h3><?php echo htmlspecialchars($product->HoTen, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã Sinh Viên:</strong> <?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Họ và Tên:</strong> <?php echo htmlspecialchars($product->HoTen, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Giới Tính:</strong> <?php echo htmlspecialchars($product->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($product->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Mã Ngành:</strong> <?php echo htmlspecialchars($product->MaNganh, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="col-md-6">
                    <?php if (!empty($product->Hinh)): ?>
                        <p><strong>Hình Ảnh:</strong></p>
                        <img src="/Ktra/pulic/uploads/<?php echo htmlspecialchars($product->Hinh, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="Hình sinh viên" class="img-thumbnail" style="max-width: 300px;">
                    <?php else: ?>
                        <p><strong>Hình Ảnh:</strong> Chưa có hình</p>
                        <div class="text-center">
                            <i class="fas fa-user-circle fa-5x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="/Ktra/Product/edit/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>" 
               class="btn btn-warning">Sửa Thông Tin</a>
            <a href="/Ktra/Product/delete/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">Xóa</a>
            <a href="/Ktra/Product/" class="btn btn-secondary">Quay lại Danh sách</a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <h4>Không tìm thấy sinh viên!</h4>
        <p>Sinh viên bạn đang tìm không tồn tại trong hệ thống.</p>
        <a href="/Ktra/Product/" class="btn btn-primary">Quay lại Danh sách</a>
    </div>
<?php endif; ?>

<?php include 'app/view/shares/footer.php'; ?>
