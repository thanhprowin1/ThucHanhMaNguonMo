<?php
session_start();
require_once('app/config/database.php');

class AuthController {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function login() {
        // Nếu đã đăng nhập, chuyển về trang chủ
        if (isset($_SESSION['user_id'])) {
            header('Location: /Ktra/Product/');
            exit;
        }

        // Xử lý form đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            } else {
                $result = $this->checkLogin($username, $password);
                if ($result['success']) {
                    $_SESSION['user_id'] = $result['user']->MaSV;
                    $_SESSION['user_name'] = $result['user']->HoTen;
                    $_SESSION['user_major'] = $result['user']->MaNganh;
                    $_SESSION['success'] = 'Đăng nhập thành công!';
                    header('Location: /Ktra/Product/');
                    exit;
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            }
        }

        include 'app/view/auth/login.php';
    }

    public function logout() {
        // Xóa tất cả session
        session_unset();
        session_destroy();
        
        // Khởi tạo session mới để hiển thị thông báo
        session_start();
        $_SESSION['success'] = 'Đăng xuất thành công!';
        
        header('Location: /Ktra/Auth/login');
        exit;
    }

    private function checkLogin($username, $password) {
        try {
            $query = "SELECT sv.*, nh.TenNganh 
                      FROM SinhVien sv 
                      LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                      WHERE sv.MaSV = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                // Kiểm tra password (đơn giản - so sánh trực tiếp)
                if ($user->password === $password) {
                    return [
                        'success' => true,
                        'user' => $user
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Mật khẩu không đúng!'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Mã sinh viên không tồn tại!'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ];
        }
    }

    // Kiểm tra đăng nhập (dùng cho các trang cần xác thực)
    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Ktra/Auth/login');
            exit;
        }
    }

    // Lấy thông tin user hiện tại
    public static function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'] ?? '',
                'major' => $_SESSION['user_major'] ?? ''
            ];
        }
        return null;
    }
}
?>
