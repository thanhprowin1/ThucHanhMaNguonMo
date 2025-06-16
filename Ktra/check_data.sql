-- Kiểm tra bảng HocPhan có tồn tại không
SHOW TABLES LIKE 'HocPhan';

-- Kiểm tra dữ liệu trong bảng HocPhan
SELECT * FROM HocPhan LIMIT 10;

-- Kiểm tra cấu trúc bảng HocPhan
DESCRIBE HocPhan;

-- Đếm số lượng học phần
SELECT COUNT(*) as total_subjects FROM HocPhan;

-- Kiểm tra dữ liệu với JOIN NganhHoc
SELECT hp.MaHP, hp.TenHP, hp.SoTinChi, hp.MaNganh, nh.TenNganh 
FROM HocPhan hp 
LEFT JOIN NganhHoc nh ON hp.MaNganh = nh.MaNganh
ORDER BY hp.MaHP ASC
LIMIT 10;
