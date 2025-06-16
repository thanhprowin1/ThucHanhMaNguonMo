<?php include 'app/view/shares/header.php'; ?>

<h1>Danh Sách Học Phần</h1>

<!-- Hiển thị thông báo -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Thông tin tổng quan -->
<div class="row mb-3">
    <div class="col-md-6">
        <p class="text-muted">
            Tổng số học phần: <strong><?php echo $totalSubjects; ?></strong> | 
            Trang <strong><?php echo $page; ?></strong> / <strong><?php echo $totalPages; ?></strong>
        </p>
    </div>
    <div class="col-md-6 text-right">
        <a href="/Ktra/Subject/add" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Học Phần Mới
        </a>
        <a href="/Ktra/Registration/" class="btn btn-primary">
            <i class="fas fa-user-graduate"></i> Đăng Ký Học Phần
        </a>
        <a href="/Ktra/Registration/stats" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Thống Kê
        </a>
    </div>
</div>

<?php if (isset($subjects) && !empty($subjects)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th width="15%">Mã HP</th>
                    <th width="35%">Tên Học Phần</th>
                    <th width="10%">Tín Chỉ</th>
                    <th width="20%">Ngành</th>
                    <th width="20%">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo htmlspecialchars($subject->TenHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-center">
                            <span class="badge badge-info"><?php echo htmlspecialchars($subject->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($subject->TenNganh ?? 'Chưa có', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/Ktra/Subject/show/<?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a href="/Ktra/Subject/edit/<?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="/Ktra/Subject/delete/<?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này?');">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Phân trang học phần">
            <ul class="pagination justify-content-center">
                <!-- Nút Previous -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Subject/?page=<?php echo ($page - 1); ?>" aria-label="Trang trước">
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
                        <a class="page-link" href="/Ktra/Subject/?page=1">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif;
                endif;

                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="/Ktra/Subject/?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor;

                if ($endPage < $totalPages): 
                    if ($endPage < $totalPages - 1): ?>
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Subject/?page=<?php echo $totalPages; ?>"><?php echo $totalPages; ?></a>
                    </li>
                <?php endif; ?>

                <!-- Nút Next -->
                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="/Ktra/Subject/?page=<?php echo ($page + 1); ?>" aria-label="Trang sau">
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
        <h4>Chưa có học phần nào!</h4>
        <p>Hiện tại chưa có học phần nào trong hệ thống.</p>
        <a href="/Ktra/Subject/add" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Học Phần Đầu Tiên
        </a>
    </div>
<?php endif; ?>

<?php include 'app/view/shares/footer.php'; ?>
