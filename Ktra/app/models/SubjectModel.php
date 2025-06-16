<?php
class SubjectModel {
    private $conn;
    private $table_name = "HocPhan";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSubjects($page = null, $limit = null) {
        try {
            if ($page !== null && $limit !== null) {
                $offset = ($page - 1) * $limit;
                $query = "SELECT * FROM " . $this->table_name . " ORDER BY MaHP ASC LIMIT :limit OFFSET :offset";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            } else {
                $query = "SELECT * FROM " . $this->table_name . " ORDER BY MaHP ASC";
                $stmt = $this->conn->prepare($query);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            // Debug: hiển thị lỗi
            echo "Error in getSubjects: " . $e->getMessage();
            return [];
        }
    }

    public function getTotalSubjects() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    public function getSubjectById($id) {
        $query = "SELECT hp.*, nh.TenNganh FROM " . $this->table_name . " hp 
                  LEFT JOIN NganhHoc nh ON hp.MaNganh = nh.MaNganh 
                  WHERE hp.MaHP = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addSubject($maHP, $tenHP, $soTinChi, $maNganh) {
        // Validation
        $errors = [];
        if (empty($maHP)) {
            $errors['maHP'] = 'Mã học phần không được để trống';
        }
        if (empty($tenHP)) {
            $errors['tenHP'] = 'Tên học phần không được để trống';
        }
        if (empty($soTinChi) || !is_numeric($soTinChi) || $soTinChi <= 0) {
            $errors['soTinChi'] = 'Số tín chỉ phải là số dương';
        }
        if (empty($maNganh)) {
            $errors['maNganh'] = 'Vui lòng chọn ngành học';
        }
        
        // Kiểm tra mã học phần đã tồn tại chưa
        if (!empty($maHP)) {
            $checkQuery = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE MaHP = :maHP";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':maHP', $maHP);
            $checkStmt->execute();
            $checkResult = $checkStmt->fetch(PDO::FETCH_OBJ);
            
            if ($checkResult->count > 0) {
                $errors['maHP'] = 'Mã học phần đã tồn tại';
            }
        }
        
        if (count($errors) > 0) {
            return $errors;
        }

        // Thêm vào database
        $query = "INSERT INTO " . $this->table_name . " (MaHP, TenHP, SoTinChi, MaNganh) VALUES (:maHP, :tenHP, :soTinChi, :maNganh)";
        $stmt = $this->conn->prepare($query);
        $maHP = htmlspecialchars(strip_tags($maHP));
        $tenHP = htmlspecialchars(strip_tags($tenHP));
        $soTinChi = (int)$soTinChi;
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        
        $stmt->bindParam(':maHP', $maHP);
        $stmt->bindParam(':tenHP', $tenHP);
        $stmt->bindParam(':soTinChi', $soTinChi);
        $stmt->bindParam(':maNganh', $maNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateSubject($maHP, $tenHP, $soTinChi, $maNganh) {
        $query = "UPDATE " . $this->table_name . " SET TenHP = :tenHP, SoTinChi = :soTinChi, MaNganh = :maNganh WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $maHP = htmlspecialchars(strip_tags($maHP));
        $tenHP = htmlspecialchars(strip_tags($tenHP));
        $soTinChi = (int)$soTinChi;
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        
        $stmt->bindParam(':maHP', $maHP);
        $stmt->bindParam(':tenHP', $tenHP);
        $stmt->bindParam(':soTinChi', $soTinChi);
        $stmt->bindParam(':maNganh', $maNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteSubject($maHP) {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lấy học phần theo ngành
    public function getSubjectsByMajor($maNganh) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaNganh = :maNganh ORDER BY TenHP ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
?>
