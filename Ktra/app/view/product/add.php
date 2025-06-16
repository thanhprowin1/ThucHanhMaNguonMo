<?php include 'app/view/shares/header.php'; ?>

<h1>Thêm Sinh Viên Mới</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="/Ktra/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
    <div class="form-group">
        <label for="maSV">Mã Sinh Viên:</label>
        <input type="text" id="maSV" name="maSV" class="form-control" value="<?php echo isset($_POST['maSV']) ? htmlspecialchars($_POST['maSV'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="hoTen">Họ và Tên:</label>
        <input type="text" id="hoTen" name="hoTen" class="form-control" value="<?php echo isset($_POST['hoTen']) ? htmlspecialchars($_POST['hoTen'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="gioiTinh">Giới Tính:</label>
        <select id="gioiTinh" name="gioiTinh" class="form-control" required>
            <option value="">-- Chọn giới tính --</option>
            <option value="Nam" <?php echo (isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
            <option value="Nữ" <?php echo (isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="ngaySinh">Ngày Sinh:</label>
        <input type="date" id="ngaySinh" name="ngaySinh" class="form-control" value="<?php echo isset($_POST['ngaySinh']) ? htmlspecialchars($_POST['ngaySinh'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="hinh">Hình Ảnh:</label>
        <input type="file" id="hinh" name="hinh" class="form-control-file" accept="image/*" onchange="previewImage(this)">
        <small class="form-text text-muted">Chọn file hình ảnh (JPG, PNG, GIF). Tối đa 2MB.</small>
        <div id="imagePreview" class="mt-2" style="display: none;">
            <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
        </div>
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
    </div>
    
    <button type="submit" class="btn btn-primary">Thêm Sinh Viên</button>
    <a href="/Ktra/Product/" class="btn btn-secondary">Quay lại Danh sách</a>
</form>

<script>
function validateForm() {
    var maSV = document.getElementById('maSV').value;
    var hoTen = document.getElementById('hoTen').value;
    var gioiTinh = document.getElementById('gioiTinh').value;
    var ngaySinh = document.getElementById('ngaySinh').value;
    var maNganh = document.getElementById('maNganh').value;
    var hinh = document.getElementById('hinh').files[0];

    if (maSV.trim() === '') {
        alert('Vui lòng nhập Mã Sinh Viên');
        return false;
    }

    if (hoTen.trim() === '') {
        alert('Vui lòng nhập Họ và Tên');
        return false;
    }

    if (gioiTinh === '') {
        alert('Vui lòng chọn Giới Tính');
        return false;
    }

    if (ngaySinh === '') {
        alert('Vui lòng chọn Ngày Sinh');
        return false;
    }

    if (maNganh === '') {
        alert('Vui lòng chọn Ngành Học');
        return false;
    }

    // Kiểm tra file hình ảnh
    if (hinh) {
        var fileSize = hinh.size / 1024 / 1024; // MB
        var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

        if (fileSize > 2) {
            alert('Kích thước file không được vượt quá 2MB');
            return false;
        }

        if (!allowedTypes.includes(hinh.type)) {
            alert('Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF)');
            return false;
        }
    }

    return true;
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'app/view/shares/footer.php'; ?>
