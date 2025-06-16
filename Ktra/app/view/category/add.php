<?php include 'app/view/shares/header.php'; ?>

<h1>Thêm Ngành Học Mới</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/Ktra/Category/save" onsubmit="return validateForm();">
    <div class="form-group">
        <label for="maNganh">Mã Ngành:</label>
        <input type="text" id="maNganh" name="maNganh" class="form-control" 
               value="<?php echo isset($_POST['maNganh']) ? htmlspecialchars($_POST['maNganh'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
               required placeholder="Ví dụ: CNTT, KT, QT...">
        <small class="form-text text-muted">Nhập mã ngành (viết tắt)</small>
    </div>
    
    <div class="form-group">
        <label for="tenNganh">Tên Ngành:</label>
        <input type="text" id="tenNganh" name="tenNganh" class="form-control" 
               value="<?php echo isset($_POST['tenNganh']) ? htmlspecialchars($_POST['tenNganh'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
               required placeholder="Ví dụ: Công nghệ thông tin">
        <small class="form-text text-muted">Nhập tên đầy đủ của ngành học</small>
    </div>
    
    <button type="submit" class="btn btn-primary">Thêm Ngành Học</button>
    <a href="/Ktra/Category/list" class="btn btn-secondary">Quay lại Danh sách</a>
</form>

<script>
function validateForm() {
    var maNganh = document.getElementById('maNganh').value;
    var tenNganh = document.getElementById('tenNganh').value;
    
    if (maNganh.trim() === '') {
        alert('Vui lòng nhập Mã Ngành');
        return false;
    }
    
    if (tenNganh.trim() === '') {
        alert('Vui lòng nhập Tên Ngành');
        return false;
    }
    
    // Kiểm tra độ dài mã ngành
    if (maNganh.length > 10) {
        alert('Mã ngành không được quá 10 ký tự');
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
