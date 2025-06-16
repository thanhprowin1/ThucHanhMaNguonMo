<?php include 'app/view/shares/header.php'; ?>

<h1>Danh sách Sinh Viên</h1>

<!-- Thông tin tổng quan -->
<div class="row mb-3">
    <div class="col-md-6">
        <p class="text-muted">
            Tổng số sinh viên: <strong><?php echo $totalProducts; ?></strong> |
            Trang <strong><?php echo $page; ?></strong> / <strong><?php echo $totalPages; ?></strong>
        </p>
    </div>
    <div class="col-md-6 text-right">
        <a href="/Ktra/Product/add" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Sinh Viên mới
        </a>
    </div>
</div>

<?php if (!empty($products)): ?>
    <!-- Danh sách sinh viên -->
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <a href="/Ktra/Product/show/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>"
                               class="text-white text-decoration-none">
                                <?php echo htmlspecialchars($product->HoTen, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($product->Hinh)): ?>
                            <div class="text-center mb-3">
                                <img src="/Ktra/pulic/uploads/<?php echo htmlspecialchars($product->Hinh, ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="Hình sinh viên" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                            </div>
                        <?php endif; ?>
                        <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($product->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($product->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Ngành học:</strong> <?php echo htmlspecialchars($product->TenNganh ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="/Ktra/Product/show/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>"
                               class="btn btn-info btn-sm">Xem</a>
                            <a href="/Ktra/Product/edit/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>"
                               class="btn btn-warning btn-sm">Sửa</a>
                            <a href="/Ktra/Product/delete/<?php echo htmlspecialchars($product->MaSV, ENT_QUOTES, 'UTF-8'); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">Xóa</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Phân trang -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Phân trang sinh viên">
            <ul class="pagination justify-content-center">
                <!-- Nút Previous -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Product/?page=<?php echo ($page - 1); ?>" aria-label="Trang trước">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                <?php endif; ?>

                <!-- Các số trang -->
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);

                if ($startPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Product/?page=1">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif;
                endif;

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="/Ktra/Product/?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor;

                if ($endPage < $totalPages):
                    if ($endPage < $totalPages - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Product/?page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
                    </li>
                <?php endif; ?>

                <!-- Nút Next -->
                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Product/?page=<?php echo ($page + 1); ?>" aria-label="Trang sau">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-info text-center">
        <h4>Chưa có sinh viên nào!</h4>
        <p>Hiện tại chưa có sinh viên nào trong hệ thống.</p>
        <a href="/Ktra/Product/add" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Sinh Viên Đầu Tiên
        </a>
    </div>
<?php endif; ?>

<?php include 'app/view/shares/footer.php'; ?>