<?php
// Require SessionHelper và các file cần thiết
require_once('app/config/database.php');
require_once('app/models/ProductModel.php'); // Giả sử đã điều chỉnh cho SinhVien
require_once('app/models/CategoryModel.php'); // Giả sử đã điều chỉnh cho NganhHoc

class ProductController {
    private $productModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db); // Model cho SinhVien
    }

    public function index() {
        // Lấy trang hiện tại từ URL, mặc định là trang 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        // Số bản ghi trên mỗi trang
        $limit = 5;

        // Lấy dữ liệu sinh viên với phân trang
        $products = $this->productModel->getProducts($page, $limit);

        // Lấy tổng số sinh viên để tính số trang
        $totalProducts = $this->productModel->getTotalProducts();
        $totalPages = ceil($totalProducts / $limit);

        // Truyền dữ liệu vào view
        include 'app/view/product/list.php';
    }

    public function show($maSV) {
        $product = $this->productModel->getProductById($maSV);
        if ($product) {
            include 'app/view/product/show.php';
        } else {
            echo "Không thấy sinh viên.";
        }
    }

    public function add() {
        $categories = (new CategoryModel($this->db))->getCategories(); // Lấy danh sách ngành học
        include 'app/view/product/add.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $hoTen = $_POST['hoTen'] ?? '';
            $gioiTinh = $_POST['gioiTinh'] ?? '';
            $ngaySinh = $_POST['ngaySinh'] ?? '';
            $maNganh = $_POST['maNganh'] ?? null;

            // Xử lý upload hình ảnh
            $hinh = '';
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $uploadResult = $this->uploadImage($_FILES['hinh']);
                if ($uploadResult['success']) {
                    $hinh = $uploadResult['filename'];
                } else {
                    $errors = [$uploadResult['error']];
                    $categories = (new CategoryModel($this->db))->getCategories();
                    include 'app/view/product/add.php';
                    return;
                }
            }

            $result = $this->productModel->addProduct($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh);
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/view/product/add.php';
            } else {
                header('Location: /Ktra/Product'); // Điều hướng sau khi thêm thành công
                exit; // Đảm bảo dừng script sau redirect
            }
        }
    }

    public function edit($maSV) {
        $product = $this->productModel->getProductById($maSV);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/view/product/edit.php';
        } else {
            echo "Không thấy sinh viên.";
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];

            // Lấy thông tin sinh viên hiện tại
            $currentProduct = $this->productModel->getProductById($maSV);
            $hinh = $currentProduct->Hinh; // Giữ hình cũ mặc định

            // Xử lý upload hình ảnh mới nếu có
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $uploadResult = $this->uploadImage($_FILES['hinh']);
                if ($uploadResult['success']) {
                    // Xóa hình cũ nếu có
                    if (!empty($currentProduct->Hinh)) {
                        $oldImagePath = 'pulic/uploads/' . $currentProduct->Hinh;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $hinh = $uploadResult['filename'];
                } else {
                    $errors = [$uploadResult['error']];
                    $product = $currentProduct;
                    $categories = (new CategoryModel($this->db))->getCategories();
                    include 'app/view/product/edit.php';
                    return;
                }
            }

            $edit = $this->productModel->updateProduct($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh);
            if ($edit) {
                header('Location: /Ktra/Product');
                exit;
            } else {
                echo "Đã xảy ra lỗi khi lưu sinh viên.";
            }
        }
    }

    public function delete($maSV) {
        // Lấy thông tin sinh viên để xóa hình ảnh
        $product = $this->productModel->getProductById($maSV);

        if ($this->productModel->deleteProduct($maSV)) {
            // Xóa hình ảnh nếu có
            if (!empty($product->Hinh)) {
                $imagePath = 'pulic/uploads/' . $product->Hinh;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            header('Location: /Ktra/Product');
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa sinh viên.";
        }
    }

    private function uploadImage($file) {
        $uploadDir = 'pulic/uploads/';
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Kiểm tra loại file
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF)'];
        }

        // Kiểm tra kích thước file
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'Kích thước file không được vượt quá 2MB'];
        }

        // Tạo tên file unique
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Upload file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'error' => 'Không thể upload file'];
        }
    }
}
?>
