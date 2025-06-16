<?php
// Require SessionHelper và các file cần thiết
session_start();
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php'); // Giả sử đã điều chỉnh cho NganhHoc

class CategoryController {
    private $categoryModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db); // Model cho NganhHoc
    }

    public function list() {
        // Lấy trang hiện tại từ URL, mặc định là trang 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        // Số bản ghi trên mỗi trang
        $limit = 10;

        // Lấy dữ liệu ngành học với phân trang
        $categories = $this->categoryModel->getCategories($page, $limit);

        // Lấy tổng số ngành học để tính số trang
        $totalCategories = $this->categoryModel->getTotalCategories();
        $totalPages = ceil($totalCategories / $limit);

        // Truyền dữ liệu vào view
        include 'app/view/category/list.php';
    }

    public function show($maNganh) {
        $category = $this->categoryModel->getCategoryById($maNganh); // Giả sử có phương thức này
        if ($category) {
            include 'app/view/category/show.php';
        } else {
            echo "Không thấy ngành học.";
        }
    }

    public function add() {
        include 'app/view/category/add.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maNganh = $_POST['maNganh'] ?? '';
            $tenNganh = $_POST['tenNganh'] ?? '';

            $result = $this->categoryModel->addCategory($maNganh, $tenNganh);
            if (is_array($result)) {
                $errors = $result;
                include 'app/view/category/add.php';
            } else {
                header('Location: /Ktra/Category/list');
                exit;
            }
        }
    }

    public function edit($maNganh) {
        $category = $this->categoryModel->getCategoryById($maNganh); // Giả sử có phương thức này
        if ($category) {
            include 'app/view/category/edit.php';
        } else {
            echo "Không thấy ngành học.";
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maNganh = $_POST['maNganh'];
            $tenNganh = $_POST['tenNganh'];

            $result = $this->categoryModel->updateCategory($maNganh, $tenNganh);
            if ($result) {
                header('Location: /Ktra/Category/list');
                exit;
            } else {
                $errors = ['Đã xảy ra lỗi khi cập nhật ngành học.'];
                $category = $this->categoryModel->getCategoryById($maNganh);
                include 'app/view/category/edit.php';
            }
        }
    }

    public function delete($maNganh) {
        // Kiểm tra xem có sinh viên nào đang học ngành này không
        $query = "SELECT COUNT(*) as count FROM SinhVien WHERE MaNganh = :maNganh";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result->count > 0) {
            // Có sinh viên đang học ngành này, không thể xóa
            $_SESSION['error'] = "Không thể xóa ngành học này vì còn có {$result->count} sinh viên đang học.";
            header('Location: /Ktra/Category/list');
            exit;
        }

        if ($this->categoryModel->deleteCategory($maNganh)) {
            $_SESSION['success'] = "Xóa ngành học thành công.";
            header('Location: /Ktra/Category/list');
            exit;
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi khi xóa ngành học.";
            header('Location: /Ktra/Category/list');
            exit;
        }
    }
}
?>