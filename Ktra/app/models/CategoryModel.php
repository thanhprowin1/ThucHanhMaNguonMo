<?php
class CategoryModel {
    private $conn;
    private $table_name = "NganhHoc";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCategories($page = null, $limit = null) {
        if ($page !== null && $limit !== null) {
            $offset = ($page - 1) * $limit;
            $query = "SELECT MaNganh as id, TenNganh as name, '' as description FROM " . $this->table_name . "
                      ORDER BY MaNganh ASC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        } else {
            $query = "SELECT MaNganh as id, TenNganh as name, '' as description FROM " . $this->table_name . "
                      ORDER BY MaNganh ASC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getTotalCategories() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    public function getCategoryById($id) {
        $query = "SELECT MaNganh as id, TenNganh as name, '' as description FROM " . $this->table_name . " WHERE MaNganh = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addCategory($maNganh, $tenNganh) {
        // Validation
        $errors = [];
        if (empty($maNganh)) {
            $errors['maNganh'] = 'Mã ngành không được để trống';
        }
        if (empty($tenNganh)) {
            $errors['tenNganh'] = 'Tên ngành không được để trống';
        }

        // Kiểm tra mã ngành đã tồn tại chưa
        if (!empty($maNganh)) {
            $checkQuery = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE MaNganh = :maNganh";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':maNganh', $maNganh);
            $checkStmt->execute();
            $checkResult = $checkStmt->fetch(PDO::FETCH_OBJ);

            if ($checkResult->count > 0) {
                $errors['maNganh'] = 'Mã ngành đã tồn tại';
            }
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Thêm vào database
        $query = "INSERT INTO " . $this->table_name . " (MaNganh, TenNganh) VALUES (:maNganh, :tenNganh)";
        $stmt = $this->conn->prepare($query);
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        $tenNganh = htmlspecialchars(strip_tags($tenNganh));
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->bindParam(':tenNganh', $tenNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateCategory($maNganh, $tenNganh) {
        $query = "UPDATE " . $this->table_name . " SET TenNganh = :tenNganh WHERE MaNganh = :maNganh";
        $stmt = $this->conn->prepare($query);
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        $tenNganh = htmlspecialchars(strip_tags($tenNganh));
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->bindParam(':tenNganh', $tenNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteCategory($maNganh) {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaNganh = :maNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maNganh', $maNganh);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>