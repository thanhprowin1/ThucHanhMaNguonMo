<?php include 'app/view/shares/header.php'; ?>

<h1>Sửa Thông Tin Sinh Viên</h1> <!-- Đổi thành "Sửa Thông Tin Sinh Viên" -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/Ktra/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
    <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>"> <!-- Đổi thành "maSV" -->
    <div class="form-group">
        <label for="hoTen">Họ và tên:</label> <!-- Đổi thành "Họ và tên" -->
        <input type="text" id="hoTen" name="hoTen" class="form-control" value="<?php echo htmlspecialchars($product->HoTen, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="gioiTinh">Giới tính:</label> <!-- Đổi thành "Giới tính" -->
        <input type="text" id="gioiTinh" name="gioiTinh" class="form-control" value="<?php echo htmlspecialchars($product->GioiTinh, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="ngaySinh">Ngày sinh:</label> <!-- Đổi thành "Ngày sinh" -->
        <input type="date" id="ngaySinh" name="ngaySinh" class="form-control" value="<?php echo htmlspecialchars($product->NgaySinh, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="hinh">Hình ảnh:</label>
        <?php if (!empty($product->Hinh)): ?>
            <div class="mb-2">
                <img src="/Ktra/pulic/uploads/<?php echo htmlspecialchars($product->Hinh, ENT_QUOTES, 'UTF-8'); ?>"
                     alt="Hình hiện tại" class="img-thumbnail" style="max-width: 200px;">
                <p class="text-muted">Hình ảnh hiện tại</p>
            </div>
        <?php endif; ?>
        <input type="file" id="hinh" name="hinh" class="form-control-file" accept="image/*" onchange="previewImage(this)">
        <small class="form-text text-muted">Chọn file mới để thay đổi hình ảnh (JPG, PNG, GIF). Tối đa 2MB.</small>
        <div id="imagePreview" class="mt-2" style="display: none;">
            <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
        </div>
    </div>
    <div class="form-group">
        <label for="maNganh">Ngành học:</label> <!-- Đổi thành "Ngành học" -->
        <select id="maNganh" name="maNganh" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $category->id == $product->MaNganh ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button> <!-- Đổi thành "Lưu Thay Đổi" -->
</form>
<a href="/Ktra/Product/" class="btn btn-secondary mt-2">Quay lại Danh sách Sinh Viên</a> <!-- Đổi thành "Quay lại Danh sách Sinh Viên" -->

<script>
function validateForm() {
    var hinh = document.getElementById('hinh').files[0];

    // Kiểm tra file hình ảnh nếu có upload
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