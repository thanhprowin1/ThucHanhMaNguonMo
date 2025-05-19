<?php include 'app/views/shares/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh sách sản phẩm</h1>
    <a href="/project1/Product/add" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
    </a>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($products as $product): ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-img-top text-center p-3" style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                <?php if (isset($product->image) && !empty($product->image)): ?>
                    <img src="/project1/<?php echo $product->image; ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                         class="img-fluid" style="max-height: 180px; object-fit: contain;">
                <?php else: ?>
                    <div class="no-image-placeholder text-muted">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p>Không có hình ảnh</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="/project1/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h5>
                <p class="card-text text-truncate"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary rounded-pill fs-6"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span>
                    <span class="badge bg-secondary"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between">
                    <a href="/project1/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="/project1/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>