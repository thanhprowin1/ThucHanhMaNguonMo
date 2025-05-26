<?php include 'app/views/shares/header.php'; ?>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 text-primary mb-0">
                    <i class="bi bi-grid-3x3-gap"></i> Danh sách sản phẩm
                </h1>
                <a href="/project1/Product/add" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
                </a>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <!-- Product Image -->
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <?php if ($product->image): ?>
                                <img src="/project1/<?php echo $product->image; ?>"
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     class="img-fluid rounded"
                                     style="max-height: 180px; max-width: 100%; object-fit: contain;">
                            <?php else: ?>
                                <div class="text-center text-muted">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-0">Không có hình ảnh</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Info -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">
                                <a href="/project1/product/show/<?php echo $product->id; ?>"
                                   class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>

                            <p class="card-text text-muted small mb-2">
                                <?php echo htmlspecialchars(substr($product->description, 0, 100), ENT_QUOTES, 'UTF-8'); ?>
                                <?php if (strlen($product->description) > 100): ?>...<?php endif; ?>
                            </p>

                            <div class="mb-2">
                                <span class="badge bg-secondary">
                                    <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-primary mb-0 fw-bold">
                                        <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                    </h6>
                                </div>

                                <!-- Action Buttons -->
                                <div class="btn-group w-100" role="group">
                                    <a href="/project1/product/addToCart/<?php echo $product->id; ?>"
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                    </a>
                                    <a href="/project1/Product/edit/<?php echo $product->id; ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/project1/Product/delete/<?php echo $product->id; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="text-muted mb-3">Chưa có sản phẩm nào</h3>
                        <p class="text-muted mb-4">Hãy thêm sản phẩm đầu tiên để bắt đầu!</p>
                        <a href="/project1/Product/add" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm mới
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card-title a:hover {
    color: #0d6efd !important;
}

.btn-group .btn {
    flex: 1;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>