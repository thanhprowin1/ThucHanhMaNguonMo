<?php
class ProductModel { // Đổi tên class thành SinhVienModel nếu bạn muốn rõ ràng hơn
    private $conn;
    private $table_name = "SinhVien"; // Sử dụng bảng SinhVien từ database Test1

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProducts($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;

        $query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, sv.MaNganh, nh.TenNganh
                  FROM " . $this->table_name . " sv
                  LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
                  ORDER BY sv.MaSV ASC
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    public function getProductById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaSV = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $errors = [];
        if (empty($maSV)) {
            $errors['maSV'] = 'Mã sinh viên không được để trống';
        }
        if (empty($hoTen)) {
            $errors['hoTen'] = 'Họ tên không được để trống';
        }
        if (empty($gioiTinh)) {
            $errors['gioiTinh'] = 'Giới tính không được để trống';
        }
        if (empty($ngaySinh)) {
            $errors['ngaySinh'] = 'Ngày sinh không được để trống';
        } elseif (!DateTime::createFromFormat('Y-m-d', $ngaySinh)) {
            $errors['ngaySinh'] = 'Định dạng ngày sinh không hợp lệ (YYYY-MM-DD)';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                  VALUES (:maSV, :hoTen, :gioiTinh, :ngaySinh, :hinh, :maNganh)";
        $stmt = $this->conn->prepare($query);
        $maSV = htmlspecialchars(strip_tags($maSV));
        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));
        $ngaySinh = htmlspecialchars(strip_tags($ngaySinh));
        $hinh = htmlspecialchars(strip_tags($hinh));
        $maNganh = htmlspecialchars(strip_tags($maNganh));

        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':hinh', $hinh);
        $stmt->bindParam(':maNganh', $maNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateProduct($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $query = "UPDATE " . $this->table_name . " SET HoTen = :hoTen, GioiTinh = :gioiTinh, 
                  NgaySinh = :ngaySinh, Hinh = :hinh, MaNganh = :maNganh WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $maSV = htmlspecialchars(strip_tags($maSV));
        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));
        $ngaySinh = htmlspecialchars(strip_tags($ngaySinh));
        $hinh = htmlspecialchars(strip_tags($hinh));
        $maNganh = htmlspecialchars(strip_tags($maNganh));

        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':hinh', $hinh);
        $stmt->bindParam(':maNganh', $maNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>