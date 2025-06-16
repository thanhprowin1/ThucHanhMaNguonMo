-- Kiểm tra cấu trúc bảng HocPhan hiện tại
DESCRIBE HocPhan;

-- Nếu bảng không tồn tại, tạo bảng mới
CREATE TABLE IF NOT EXISTS HocPhan (
    MaHP VARCHAR(10) PRIMARY KEY,
    TenHP VARCHAR(100) NOT NULL,
    SoTinChi INT NOT NULL CHECK (SoTinChi > 0)
);

-- Xóa dữ liệu cũ (nếu có)
DELETE FROM HocPhan;

-- Thêm dữ liệu mẫu
INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES
('CNTT01', 'Lập trình C', 3),
('CNTT02', 'Cơ sở dữ liệu', 2),
('CNTT03', 'Xác suất thống kê', 3),
('CTKO01', 'Kinh tế vi mô', 2),
('CTKO02', 'Kinh tế vĩ mô', 3),
('CTKO03', 'Kế toán tài chính', 3);

-- Kiểm tra dữ liệu đã thêm
SELECT * FROM HocPhan;
SELECT COUNT(*) as total FROM HocPhan;
