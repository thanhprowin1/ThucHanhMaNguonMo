-- Thêm cột password vào bảng SinhVien
ALTER TABLE SinhVien ADD COLUMN password VARCHAR(255) DEFAULT NULL;

-- Cập nhật password mặc định cho các sinh viên hiện có (password = mã sinh viên)
UPDATE SinhVien SET password = MaSV WHERE password IS NULL;

-- Ví dụ: Nếu muốn password phức tạp hơn, có thể dùng MD5 hoặc bcrypt
-- UPDATE SinhVien SET password = MD5(MaSV) WHERE password IS NULL;
