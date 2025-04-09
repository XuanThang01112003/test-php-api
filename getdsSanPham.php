<?php
// Cấu hình CORS để frontend có thể gọi API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../config/database.php');

try {
    // Truy vấn lấy các sản phẩm có TenLoai là "Linh kiện máy tính"
    $sql = "SELECT * FROM sanpham WHERE TenLoai = :tenloai";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['tenloai' => 'Phụ kiện điện thoại']);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch data as associative array

    // Kiểm tra nếu có sản phẩm trả về
    if (empty($products)) {
        echo json_encode(['message' => 'No products found']);
        exit;
    }

    // Thêm đường dẫn ảnh đầy đủ vào mỗi sản phẩm
    foreach ($products as &$product) {
        $product['HinhAnh'] = 'http://localhost/backendWebbandodientu/images/' . $product['HinhAnh'];
    }

    // Trả về danh sách sản phẩm dưới dạng JSON
    echo json_encode($products);
} catch (PDOException $e) {
    // Xử lý lỗi khi có vấn đề với truy vấn SQL
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi truy vấn: ' . $e->getMessage()]);
}
?>
