<?php include 'app/view/shares/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">DANH SÁCH HỌC PHẦN</h2>

    <!-- Bảng danh sách học phần -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th width="25%">Mã Học Phần</th>
                    <th width="60%">Tên Học Phần</th>
                    <th width="15%" class="text-center">Số Tín Chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($subjects) && !empty($subjects)): ?>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($subject->MaHP, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars($subject->TenHP, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center">
                                <span class="badge badge-info"><?php echo htmlspecialchars($subject->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Không có học phần nào trong hệ thống
                            <?php
                            // Debug info
                            if (isset($subjects)) {
                                echo "<br><small>Subjects array exists, count: " . count($subjects) . "</small>";
                            } else {
                                echo "<br><small>Subjects variable not set</small>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($subjects) && !empty($subjects)): ?>
        <div class="mt-3">
            <small class="text-muted">
                <i class="fas fa-info-circle"></i> 
                Tổng cộng: <strong><?php echo count($subjects); ?></strong> học phần
            </small>
        </div>
    <?php endif; ?>
</div>

<style>
/* Custom CSS để làm đẹp bảng */
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-top: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}

.badge {
    font-size: 0.9em;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>

<?php include 'app/view/shares/footer.php'; ?>
