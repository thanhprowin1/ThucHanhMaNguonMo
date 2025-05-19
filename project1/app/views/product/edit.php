<?php include 'app/views/shares/header.php'; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-dark">
        <h1 class="h3 mb-0"><i class="bi bi-pencil-square"></i> Sửa sản phẩm</h1>
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
<form method="POST" action="/project1/Product/update" enctype="multipart/form-data"
    onsubmit="return validateForm();">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php
                                                                                echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
            required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                        ?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
            value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>"
            required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo $category->id
                                                                    == $product->category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image" class="form-control">
        <input type="hidden" name="existing_image" value="<?php echo $product->image;
                                                            ?>">
        <?php if (isset($product->image) && !empty($product->image)): ?>
<img src="/project1/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 100px;">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/project1/Product/" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>