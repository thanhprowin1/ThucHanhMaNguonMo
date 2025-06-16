<?php include 'app/view/shares/header.php'; ?>

<h1>Chi Tiết Ngành Học</h1>

<?php if (isset($category) && $category): ?>
    <div class="card">
        <div class="card-header">
            <h3><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã Ngành:</strong> <?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Tên Ngành:</strong> <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Mô tả:</strong> 
                        <?php if (!empty($category->description)): ?>
                            <?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?>
                        <?php else: ?>
                            <em>Chưa có mô tả</em>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="/Ktra/Category/edit/<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" 
               class="btn btn-warning">Sửa Thông Tin</a>
            <a href="/Ktra/Category/delete/<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Bạn có chắc chắn muốn xóa ngành học này?');">Xóa</a>
            <a href="/Ktra/Category/list" class="btn btn-secondary">Quay lại Danh sách</a>
        </div>
    </div>

    <!-- Hiển thị danh sách sinh viên thuộc ngành này -->
    <div class="mt-4">
        <h4>Sinh viên thuộc ngành này</h4>
        <div id="students-list">
            <p class="text-muted">Đang tải danh sách sinh viên...</p>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning">
        <h4>Không tìm thấy ngành học!</h4>
        <p>Ngành học bạn đang tìm không tồn tại trong hệ thống.</p>
        <a href="/Ktra/Category/list" class="btn btn-primary">Quay lại Danh sách</a>
    </div>
<?php endif; ?>

<script>
// Có thể thêm AJAX để load danh sách sinh viên thuộc ngành này
document.addEventListener('DOMContentLoaded', function() {
    // Placeholder cho việc load sinh viên theo ngành
    document.getElementById('students-list').innerHTML = '<p class="text-info">Chức năng hiển thị sinh viên theo ngành sẽ được phát triển sau.</p>';
});
</script>

<?php include 'app/view/shares/footer.php'; ?>
