<?php
class Database {
    private $host = "localhost"; // Địa chỉ host của Laragon
    private $db_name = "Test1"; // Tên database đã tạo
    private $username = "root"; // Tên người dùng mặc định của Laragon
    private $password = ""; // Mật khẩu mặc định của Laragon (thường rỗng)
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8"); // Đảm bảo sử dụng UTF-8 để hỗ trợ tiếng Việt
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bật chế độ lỗi chi tiết
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>