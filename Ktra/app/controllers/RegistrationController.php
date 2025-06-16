<?php
session_start();
require_once('app/config/database.php');
require_once('app/models/RegistrationModel.php');
require_once('app/models/SubjectModel.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class RegistrationController {
    private $registrationModel;
    private $subjectModel;
    private $productModel;
    private $categoryModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->registrationModel = new RegistrationModel($this->db);
        $this->subjectModel = new SubjectModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Trang chính - danh sách học phần để đăng ký
    public function index() {
        // Lấy danh sách tất cả học phần
        $subjects = $this->subjectModel->getSubjects();
        
        // Lấy danh sách sinh viên để chọn
        $students = $this->productModel->getProducts();
        
        include 'app/view/registration/index.php';
    }

    // Trang đăng ký học phần cho sinh viên cụ thể
    public function register($maSV = null) {
        if (!$maSV) {
            $_SESSION['error'] = 'Vui lòng chọn sinh viên để đăng ký học phần.';
            header('Location: /Ktra/Registration/');
            exit;
        }

        // Lấy thông tin sinh viên
        $student = $this->productModel->getProductById($maSV);
        if (!$student) {
            $_SESSION['error'] = 'Không tìm thấy sinh viên.';
            header('Location: /Ktra/Registration/');
            exit;
        }

        // Lấy danh sách học phần theo ngành của sinh viên
        $subjects = $this->subjectModel->getSubjectsByMajor($student->MaNganh);
        
        // Lấy danh sách học phần đã đăng ký
        $registeredSubjects = $this->registrationModel->getRegisteredSubjects($maSV);
        
        // Tính tổng số tín chỉ đã đăng ký
        $totalCredits = $this->registrationModel->getTotalCredits($maSV);

        include 'app/view/registration/register.php';
    }

    // Xử lý đăng ký học phần
    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $maHP = $_POST['maHP'] ?? '';

            if (empty($maSV) || empty($maHP)) {
                $_SESSION['error'] = 'Thông tin không hợp lệ.';
                header('Location: /Ktra/Registration/');
                exit;
            }

            $result = $this->registrationModel->registerSubject($maSV, $maHP);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }

            header('Location: /Ktra/Registration/register/' . $maSV);
            exit;
        }
    }

    // Hủy đăng ký học phần
    public function unregister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $maHP = $_POST['maHP'] ?? '';

            if (empty($maSV) || empty($maHP)) {
                $_SESSION['error'] = 'Thông tin không hợp lệ.';
                header('Location: /Ktra/Registration/');
                exit;
            }

            $result = $this->registrationModel->unregisterSubject($maSV, $maHP);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }

            header('Location: /Ktra/Registration/register/' . $maSV);
            exit;
        }
    }

    // Xem danh sách sinh viên đăng ký theo học phần
    public function viewBySubject($maHP) {
        $subject = $this->subjectModel->getSubjectById($maHP);
        if (!$subject) {
            $_SESSION['error'] = 'Không tìm thấy học phần.';
            header('Location: /Ktra/Registration/');
            exit;
        }

        $students = $this->registrationModel->getStudentsBySubject($maHP);
        include 'app/view/registration/by_subject.php';
    }

    // Thống kê đăng ký
    public function stats() {
        $stats = $this->registrationModel->getRegistrationStats();
        include 'app/view/registration/stats.php';
    }
}
?>
