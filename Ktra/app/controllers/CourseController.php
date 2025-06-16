<?php
session_start();
require_once('app/config/database.php');
require_once('app/models/SubjectModel.php');

class CourseController {
    private $db;
    private $subjectModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->subjectModel = new SubjectModel($this->db);
    }

    public function index() {
        // Chuyển hướng đến trang list
        header('Location: /Ktra/Course/list');
        exit;
    }

    public function list() {
        try {
            // Debug: Kiểm tra kết nối database
            if (!$this->db) {
                echo "Database connection failed!";
                return;
            }

            // Lấy tất cả học phần trực tiếp từ database
            $query = "SELECT * FROM HocPhan ORDER BY MaHP ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $subjects = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Debug: Hiển thị số lượng học phần
            echo "<!-- Debug: Found " . count($subjects) . " subjects -->";

            include 'app/view/course/list.php';
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            echo "<br>Query: SELECT * FROM HocPhan ORDER BY MaHP ASC";
        }
    }
}
?>
