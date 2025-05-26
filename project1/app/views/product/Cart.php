<?php include 'app/views/shares/header.php'; ?>

<!-- Cart Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="display-6 fw-bold text-primary">
                <i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn
            </h1>
            <?php if (!empty($cart)): ?>
                <span class="badge bg-primary fs-6"><?php echo count($cart); ?> sản phẩm</span>
            <?php endif; ?>
        </div>
        <hr class="border-primary border-2 opacity-50">
    </div>
</div>

<?php if (!empty($cart)): ?>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 col-md-12 mb-4">
            <?php
            $total = 0;
            foreach ($cart as $id => $item):
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
            ?>
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Product Image -->
                            <div class="col-md-3 col-sm-4">
                                <div class="text-center">
                                    <?php if ($item['image']): ?>
                                        <img src="/project1/<?php echo $item['image']; ?>"
                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                             class="img-fluid rounded shadow-sm"
                                             style="max-height: 120px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="height: 120px;">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="col-md-6 col-sm-8">
                                <h5 class="card-title text-dark fw-bold mb-2">
                                    <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </h5>
                                <p class="text-success fw-bold fs-5 mb-2">
                                    <i class="bi bi-currency-dollar"></i>
                                    <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
                                </p>
                                <p class="text-muted mb-2">
                                    <small>Thành tiền: <span class="fw-bold text-dark"><?php echo number_format($itemTotal, 0, ',', '.'); ?> VND</span></small>
                                </p>
                            </div>

                            <!-- Quantity Display -->
                            <div class="col-md-3 col-12">
                                <div class="d-flex flex-column align-items-center">
                                    <label class="form-label fw-bold text-muted mb-2">Số lượng</label>
                                    <div class="text-center">
                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                            <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-receipt me-2"></i>Tóm tắt đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span class="fw-bold"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold fs-5">Tổng cộng:</span>
                        <span class="fw-bold fs-5 text-primary"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="/project1/Product/checkout" class="btn btn-primary btn-lg">
                            <i class="bi bi-credit-card me-2"></i>Thanh toán
                        </a>
                        <a href="/project1/Product" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Empty Cart State -->
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-muted mb-3">Giỏ hàng trống</h3>
                    <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
                    <a href="/project1/Product" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>Khám phá sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>