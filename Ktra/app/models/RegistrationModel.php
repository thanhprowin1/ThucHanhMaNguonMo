<?php
class RegistrationModel {
    private $conn;
    private $table_name = "DangKyHocPhan";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đăng ký học phần
    public function registerSubject($maSV, $maHP) {
        // Kiểm tra xem đã đăng ký chưa
        $checkQuery = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE MaSV = :maSV AND MaHP = :maHP";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':maSV', $maSV);
        $checkStmt->bindParam(':maHP', $maHP);
        $checkStmt->execute();
        $checkResult = $checkStmt->fetch(PDO::FETCH_OBJ);
        
        if ($checkResult->count > 0) {
            return ['success' => false, 'message' => 'Bạn đã đăng ký học phần này rồi!'];
        }

        // Thêm đăng ký mới
        $query = "INSERT INTO " . $this->table_name . " (MaSV, MaHP, NgayDangKy) VALUES (:maSV, :maHP, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':maHP', $maHP);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Đăng ký học phần thành công!'];
        }
        return ['success' => false, 'message' => 'Có lỗi xảy ra khi đăng ký!'];
    }

    // Hủy đăng ký học phần
    public function unregisterSubject($maSV, $maHP) {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = :maSV AND MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':maHP', $maHP);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Hủy đăng ký thành công!'];
        }
        return ['success' => false, 'message' => 'Có lỗi xảy ra khi hủy đăng ký!'];
    }

    // Lấy danh sách học phần đã đăng ký của sinh viên
    public function getRegisteredSubjects($maSV) {
        $query = "SELECT dk.*, hp.TenHP, hp.SoTinChi, nh.TenNganh 
                  FROM " . $this->table_name . " dk
                  JOIN HocPhan hp ON dk.MaHP = hp.MaHP
                  LEFT JOIN NganhHoc nh ON hp.MaNganh = nh.MaNganh
                  WHERE dk.MaSV = :maSV
                  ORDER BY dk.NgayDangKy DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    // Kiểm tra sinh viên đã đăng ký học phần chưa
    public function isRegistered($maSV, $maHP) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE MaSV = :maSV AND MaHP = :maHP";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count > 0;
    }

    // Lấy tổng số tín chỉ đã đăng ký của sinh viên
    public function getTotalCredits($maSV) {
        $query = "SELECT SUM(hp.SoTinChi) as totalCredits 
                  FROM " . $this->table_name . " dk
                  JOIN HocPhan hp ON dk.MaHP = hp.MaHP
                  WHERE dk.MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->totalCredits ?? 0;
    }

    // Lấy danh sách sinh viên đăng ký theo học phần
    public function getStudentsBySubject($maHP) {
        $query = "SELECT dk.*, sv.HoTen, sv.GioiTinh, nh.TenNganh 
                  FROM " . $this->table_name . " dk
                  JOIN SinhVien sv ON dk.MaSV = sv.MaSV
                  LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
                  WHERE dk.MaHP = :maHP
                  ORDER BY sv.HoTen ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    // Thống kê đăng ký theo học phần
    public function getRegistrationStats() {
        $query = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi, nh.TenNganh, COUNT(dk.MaSV) as SoLuongDangKy
                  FROM HocPhan hp
                  LEFT JOIN " . $this->table_name . " dk ON hp.MaHP = dk.MaHP
                  LEFT JOIN NganhHoc nh ON hp.MaNganh = nh.MaNganh
                  GROUP BY hp.MaHP, hp.TenHP, hp.SoTinChi, nh.TenNganh
                  ORDER BY SoLuongDangKy DESC, hp.TenHP ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
?>
