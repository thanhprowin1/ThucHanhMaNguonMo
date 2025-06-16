-- Script tạo bảng cho hệ thống đăng ký học phần

-- Tạo bảng HocPhan (Học phần)
CREATE TABLE IF NOT EXISTS HocPhan (
    MaHP VARCHAR(10) PRIMARY KEY,
    TenHP VARCHAR(100) NOT NULL,
    SoTinChi INT NOT NULL CHECK (SoTinChi > 0),
    MaNganh VARCHAR(10),
    FOREIGN KEY (MaNganh) REFERENCES NganhHoc(MaNganh) ON DELETE SET NULL
);

-- Tạo bảng DangKyHocPhan (Đăng ký học phần)
CREATE TABLE IF NOT EXISTS DangKyHocPhan (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    MaSV VARCHAR(10) NOT NULL,
    MaHP VARCHAR(10) NOT NULL,
    NgayDangKy DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaSV) REFERENCES SinhVien(MaSV) ON DELETE CASCADE,
    FOREIGN KEY (MaHP) REFERENCES HocPhan(MaHP) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (MaSV, MaHP)
);

-- Thêm dữ liệu mẫu cho bảng HocPhan
INSERT INTO HocPhan (MaHP, TenHP, SoTinChi, MaNganh) VALUES
('IT101', 'Lập trình cơ bản', 3, 'CNTT'),
('IT102', 'Cấu trúc dữ liệu và giải thuật', 4, 'CNTT'),
('IT103', 'Cơ sở dữ liệu', 3, 'CNTT'),
('IT104', 'Mạng máy tính', 3, 'CNTT'),
('IT105', 'Phát triển ứng dụng Web', 4, 'CNTT'),
('MATH101', 'Toán cao cấp A1', 3, 'CNTT'),
('MATH102', 'Toán cao cấp A2', 3, 'CNTT'),
('MATH103', 'Xác suất thống kê', 2, 'CNTT'),
('ENG101', 'Tiếng Anh chuyên ngành', 2, 'CNTT'),
('SOFT101', 'Công nghệ phần mềm', 3, 'CNTT');

-- Thêm dữ liệu mẫu cho các ngành khác (nếu có)
-- Ví dụ cho ngành Kinh tế (KT)
INSERT INTO HocPhan (MaHP, TenHP, SoTinChi, MaNganh) VALUES
('ECO101', 'Kinh tế học đại cương', 3, 'KT'),
('ECO102', 'Kinh tế vi mô', 3, 'KT'),
('ECO103', 'Kinh tế vĩ mô', 3, 'KT'),
('ACC101', 'Nguyên lý kế toán', 3, 'KT'),
('FIN101', 'Tài chính doanh nghiệp', 3, 'KT');

-- Ví dụ cho ngành Quản trị (QT)
INSERT INTO HocPhan (MaHP, TenHP, SoTinChi, MaNganh) VALUES
('MGT101', 'Nguyên lý quản trị', 3, 'QT'),
('MGT102', 'Quản trị nhân lực', 3, 'QT'),
('MGT103', 'Quản trị marketing', 3, 'QT'),
('MGT104', 'Quản trị chiến lược', 3, 'QT'),
('MGT105', 'Quản trị dự án', 3, 'QT');

-- Tạo index để tối ưu hóa truy vấn
CREATE INDEX idx_hocphan_nganh ON HocPhan(MaNganh);
CREATE INDEX idx_dangky_sinhvien ON DangKyHocPhan(MaSV);
CREATE INDEX idx_dangky_hocphan ON DangKyHocPhan(MaHP);
CREATE INDEX idx_dangky_ngay ON DangKyHocPhan(NgayDangKy);

-- Thêm một số ràng buộc bổ sung
ALTER TABLE HocPhan ADD CONSTRAINT chk_tinchi CHECK (SoTinChi BETWEEN 1 AND 10);

-- View để xem thống kê đăng ký
CREATE OR REPLACE VIEW v_ThongKeDangKy AS
SELECT 
    hp.MaHP,
    hp.TenHP,
    hp.SoTinChi,
    nh.TenNganh,
    COUNT(dk.MaSV) as SoLuongDangKy,
    GROUP_CONCAT(DISTINCT sv.HoTen ORDER BY sv.HoTen SEPARATOR ', ') as DanhSachSinhVien
FROM HocPhan hp
LEFT JOIN DangKyHocPhan dk ON hp.MaHP = dk.MaHP
LEFT JOIN SinhVien sv ON dk.MaSV = sv.MaSV
LEFT JOIN NganhHoc nh ON hp.MaNganh = nh.MaNganh
GROUP BY hp.MaHP, hp.TenHP, hp.SoTinChi, nh.TenNganh
ORDER BY SoLuongDangKy DESC, hp.TenHP;

-- View để xem đăng ký của từng sinh viên
CREATE OR REPLACE VIEW v_DangKySinhVien AS
SELECT 
    sv.MaSV,
    sv.HoTen,
    nh.TenNganh as NganhSinhVien,
    hp.MaHP,
    hp.TenHP,
    hp.SoTinChi,
    dk.NgayDangKy
FROM SinhVien sv
JOIN DangKyHocPhan dk ON sv.MaSV = dk.MaSV
JOIN HocPhan hp ON dk.MaHP = hp.MaHP
LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
ORDER BY sv.HoTen, dk.NgayDangKy;

-- Thêm dữ liệu đăng ký mẫu (tùy chọn)
-- INSERT INTO DangKyHocPhan (MaSV, MaHP) VALUES
-- ('SV001', 'IT101'),
-- ('SV001', 'MATH101'),
-- ('SV002', 'IT101'),
-- ('SV002', 'IT102');

COMMIT;
