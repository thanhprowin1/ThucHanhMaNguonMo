<?php include 'app/views/shares/header.php'; ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h1 class="h3 mb-0"><i class="bi bi-plus-circle"></i> Thêm sản phẩm mới</h1>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
<form method="POST" action="/project1/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá:</label>
                                <div class="input-group">
                                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                                    <span class="input-group-text">VND</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục:</label>
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <option value="" disabled selected>Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->id; ?>">
                                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh sản phẩm:</label>
                        <div class="card">
                            <div class="card-body text-center">
                                <div id="imagePreviewContainer" style="display: none; margin-bottom: 15px;">
                                    <img id="imagePreview" src="#" alt="Xem trước hình ảnh" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                </div>
                                <div class="mb-3" id="uploadPlaceholder">
                                    <i class="bi bi-cloud-arrow-up" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="text-muted">Chọn hình ảnh để tải lên</p>
                                </div>
                                <div class="input-group">
                                    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(this);">
                                </div>
                                <small class="form-text text-muted mt-2">
                                    Hỗ trợ định dạng: JPG, JPEG, PNG, GIF. Kích thước tối đa: 10MB
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/project1/Product/" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Lưu sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>