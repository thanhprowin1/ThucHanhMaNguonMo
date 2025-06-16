<?php
session_start();
require_once('app/config/database.php');
require_once('app/models/SubjectModel.php');
require_once('app/models/CategoryModel.php');

class SubjectController {
    private $subjectModel;
    private $categoryModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->subjectModel = new SubjectModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index() {
        // Lấy trang hiện tại từ URL, mặc định là trang 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        
        // Số bản ghi trên mỗi trang
        $limit = 10;
        
        // Lấy dữ liệu học phần với phân trang
        $subjects = $this->subjectModel->getSubjects($page, $limit);
        
        // Lấy tổng số học phần để tính số trang
        $totalSubjects = $this->subjectModel->getTotalSubjects();
        $totalPages = ceil($totalSubjects / $limit);
        
        // Truyền dữ liệu vào view
        include 'app/view/subject/list.php';
    }

    public function show($maHP) {
        $subject = $this->subjectModel->getSubjectById($maHP);
        if ($subject) {
            include 'app/view/subject/show.php';
        } else {
            echo "Không thấy học phần.";
        }
    }

    public function add() {
        $categories = $this->categoryModel->getCategories();
        include 'app/view/subject/add.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maHP = $_POST['maHP'] ?? '';
            $tenHP = $_POST['tenHP'] ?? '';
            $soTinChi = $_POST['soTinChi'] ?? '';
            $maNganh = $_POST['maNganh'] ?? '';

            $result = $this->subjectModel->addSubject($maHP, $tenHP, $soTinChi, $maNganh);
            if (is_array($result)) {
                $errors = $result;
                $categories = $this->categoryModel->getCategories();
                include 'app/view/subject/add.php';
            } else {
                $_SESSION['success'] = 'Thêm học phần thành công!';
                header('Location: /Ktra/Subject/');
                exit;
            }
        }
    }

    public function edit($maHP) {
        $subject = $this->subjectModel->getSubjectById($maHP);
        $categories = $this->categoryModel->getCategories();
        if ($subject) {
            include 'app/view/subject/edit.php';
        } else {
            echo "Không thấy học phần.";
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'];
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];
            $maNganh = $_POST['maNganh'];

            $result = $this->subjectModel->updateSubject($maHP, $tenHP, $soTinChi, $maNganh);
            if ($result) {
                $_SESSION['success'] = 'Cập nhật học phần thành công!';
                header('Location: /Ktra/Subject/');
                exit;
            } else {
                $errors = ['Đã xảy ra lỗi khi cập nhật học phần.'];
                $subject = $this->subjectModel->getSubjectById($maHP);
                $categories = $this->categoryModel->getCategories();
                include 'app/view/subject/edit.php';
            }
        }
    }

    public function delete($maHP) {
        // Kiểm tra xem có sinh viên nào đang đăng ký học phần này không
        $query = "SELECT COUNT(*) as count FROM DangKyHocPhan WHERE MaHP = :maHP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($result->count > 0) {
            $_SESSION['error'] = "Không thể xóa học phần này vì có {$result->count} sinh viên đang đăng ký.";
            header('Location: /Ktra/Subject/');
            exit;
        }
        
        if ($this->subjectModel->deleteSubject($maHP)) {
            $_SESSION['success'] = "Xóa học phần thành công.";
            header('Location: /Ktra/Subject/');
            exit;
        } else {
            $_SESSION['error'] = "Đã xảy ra lỗi khi xóa học phần.";
            header('Location: /Ktra/Subject/');
            exit;
        }
    }
}
?>
