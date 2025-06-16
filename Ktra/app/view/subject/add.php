<?php include 'app/view/shares/header.php'; ?>

<h1>Thêm Học Phần Mới</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/Ktra/Subject/save" onsubmit="return validateForm();">
    <div class="form-group">
        <label for="maHP">Mã Học Phần:</label>
        <input type="text" id="maHP" name="maHP" class="form-control" 
               value="<?php echo isset($_POST['maHP']) ? htmlspecialchars($_POST['maHP'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
               required placeholder="Ví dụ: IT101, MATH201...">
        <small class="form-text text-muted">Nhập mã học phần (viết tắt)</small>
    </div>
    
    <div class="form-group">
        <label for="tenHP">Tên Học Phần:</label>
        <input type="text" id="tenHP" name="tenHP" class="form-control" 
               value="<?php echo isset($_POST['tenHP']) ? htmlspecialchars($_POST['tenHP'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
               required placeholder="Ví dụ: Lập trình cơ bản">
        <small class="form-text text-muted">Nhập tên đầy đủ của học phần</small>
    </div>

    <div class="form-group">
        <label for="soTinChi">Số Tín Chỉ:</label>
        <input type="number" id="soTinChi" name="soTinChi" class="form-control" 
               value="<?php echo isset($_POST['soTinChi']) ? htmlspecialchars($_POST['soTinChi'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
               required min="1" max="10" placeholder="Ví dụ: 3">
        <small class="form-text text-muted">Nhập số tín chỉ (1-10)</small>
    </div>
    
    <div class="form-group">
        <label for="maNganh">Ngành Học:</label>
        <select id="maNganh" name="maNganh" class="form-control" required>
            <option value="">-- Chọn ngành học --</option>
            <?php if (isset($categories) && !empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" 
                            <?php echo (isset($_POST['maNganh']) && $_POST['maNganh'] == $category->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <small class="form-text text-muted">Chọn ngành học mà học phần này thuộc về</small>
    </div>
    
    <button type="submit" class="btn btn-primary">Thêm Học Phần</button>
    <a href="/Ktra/Subject/" class="btn btn-secondary">Quay lại Danh sách</a>
</form>

<script>
function validateForm() {
    var maHP = document.getElementById('maHP').value;
    var tenHP = document.getElementById('tenHP').value;
    var soTinChi = document.getElementById('soTinChi').value;
    var maNganh = document.getElementById('maNganh').value;
    
    if (maHP.trim() === '') {
        alert('Vui lòng nhập Mã Học Phần');
        return false;
    }
    
    if (tenHP.trim() === '') {
        alert('Vui lòng nhập Tên Học Phần');
        return false;
    }
    
    if (soTinChi === '' || soTinChi < 1 || soTinChi > 10) {
        alert('Số tín chỉ phải từ 1 đến 10');
        return false;
    }
    
    if (maNganh === '') {
        alert('Vui lòng chọn Ngành Học');
        return false;
    }
    
    // Kiểm tra độ dài mã học phần
    if (maHP.length > 10) {
        alert('Mã học phần không được quá 10 ký tự');
        return false;
    }
    
    // Kiểm tra độ dài tên học phần
    if (tenHP.length > 100) {
        alert('Tên học phần không được quá 100 ký tự');
        return false;
    }
    
    return true;
}
</script>

<?php include 'app/view/shares/footer.php'; ?>
