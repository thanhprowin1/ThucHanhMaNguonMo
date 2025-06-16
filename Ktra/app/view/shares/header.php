<!DOCTYPE html>
<html lang="vi"> <!-- Đổi sang tiếng Việt để phù hợp với nội dung -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh Viên</title> <!-- Đổi thành "Quản lý Sinh Viên" -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý Sinh Viên</a> <!-- Đổi thành "Quản lý Sinh Viên" -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> <!-- Thêm ml-auto để căn phải -->
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Product/">Danh sách Sinh Viên</a> <!-- Đổi thành "Danh sách Sinh Viên" -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Product/add">Thêm Sinh Viên</a> <!-- Đổi thành "Thêm Sinh Viên" -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Category/list">Danh sách Ngành Học</a> <!-- Thêm liên kết đến Ngành Học -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Category/add">Thêm Ngành Học</a> <!-- Thêm liên kết đến Thêm Ngành Học -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Subject/">Danh sách Học Phần</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Ktra/Course/list">HỌC PHẦN</a>
                </li>

                <?php
                // Kiểm tra đăng nhập
                if (isset($_SESSION['user_id'])):
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User', ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <div class="dropdown-menu">
                            <span class="dropdown-item-text">
                                <small>Mã SV: <?php echo htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8'); ?></small>
                            </span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/Ktra/Auth/logout">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Ktra/Auth/login">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <!-- Nội dung chính sẽ được chèn vào đây qua các view PHP -->
    </div>

    <!-- Sửa lỗi script tag và sắp xếp thứ tự đúng -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>