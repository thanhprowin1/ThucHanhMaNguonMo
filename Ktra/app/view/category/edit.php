<?php include 'app/view/shares/header.php'; ?>

<h1>Sửa Thông Tin Ngành Học</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (isset($category) && $category): ?>
    <form method="POST" action="/Ktra/Category/update" onsubmit="return validateForm();">
        <input type="hidden" name="maNganh" value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>">
        
        <div class="form-group">
            <label for="maNganhDisplay">Mã Ngành:</label>
            <input type="text" id="maNganhDisplay" class="form-control" 
                   value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" 
                   disabled>
            <small class="form-text text-muted">Mã ngành không thể thay đổi</small>
        </div>
        
        <div class="form-group">
            <label for="tenNganh">Tên Ngành:</label>
            <input type="text" id="tenNganh" name="tenNganh" class="form-control" 
                   value="<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>" 
                   required placeholder="Nhập tên ngành học">
            <small class="form-text text-muted">Nhập tên đầy đủ của ngành học</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
        <a href="/Ktra/Category/list" class="btn btn-secondary">Quay lại Danh sách</a>
    </form>
<?php else: ?>
    <div class="alert alert-warning">
        <h4>Không tìm thấy ngành học!</h4>
        <p>Ngành học bạn đang tìm không tồn tại trong hệ thống.</p>
        <a href="/Ktra/Category/list" class="btn btn-primary">Quay lại Danh sách</a>
    </div>
<?php endif; ?>

<script>
function validateForm() {
    var tenNganh = document.getElementById('tenNganh').value;
    
    if (tenNganh.trim() === '') {
        alert('Vui lòng nhập Tên Ngành');
        return false;
    }
    
    // Kiểm tra độ dài tên ngành
    if (tenNganh.length > 100) {
        alert('Tên ngành không được quá 100 ký tự');
        return false;
    }
    
    return true;
}
</script>

<?php include 'app/view/shares/footer.php'; ?>
