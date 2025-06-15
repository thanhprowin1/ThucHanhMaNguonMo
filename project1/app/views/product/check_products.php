<?php
require_once('app/config/database.php');

// Kết nối đến cơ sở dữ liệu
$db = (new Database())->getConnection();

// Truy vấn để lấy tất cả sản phẩm
$stmt = $db->prepare('SELECT * FROM product LIMIT 5');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_OBJ);

// Hiển thị thông tin sản phẩm
echo "<h1>Thông tin sản phẩm</h1>";
echo "<pre>";
print_r($products);
echo "</pre>";

// Kiểm tra thư mục uploads
echo "<h1>Kiểm tra thư mục uploads</h1>";
$uploadDir = "uploads/";
if (is_dir($uploadDir)) {
    echo "Thư mục uploads tồn tại.<br>";
    $files = scandir($uploadDir);
    echo "Các tệp trong thư mục uploads:<br>";
    echo "<pre>";
    print_r($files);
    echo "</pre>";
} else {
    echo "Thư mục uploads không tồn tại.<br>";
}

// Kiểm tra hiển thị hình ảnh
echo "<h1>Kiểm tra hiển thị hình ảnh</h1>";
foreach ($products as $product) {
    echo "<div style='margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;'>";
    echo "<h2>{$product->name}</h2>";
    echo "<p>ID: {$product->id}</p>";
    echo "<p>Đường dẫn hình ảnh trong DB: " . ($product->image ? $product->image : "Không có") . "</p>";
    
    if (!empty($product->image)) {
        echo "<p>Kiểm tra tệp tồn tại: " . (file_exists($product->image) ? "Tồn tại" : "Không tồn tại") . "</p>";
        echo "<p>Hiển thị hình ảnh với đường dẫn gốc:</p>";
        echo "<img src='{$product->image}' style='max-width: 200px;'><br>";
        
        echo "<p>Hiển thị hình ảnh với đường dẫn /project1/:</p>";
        echo "<img src='/project1/{$product->image}' style='max-width: 200px;'><br>";
    }
    
    echo "</div>";
}
?>
