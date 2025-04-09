<?php
// CORS headers - phải đặt trước cả session_start()
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Nếu là preflight request (OPTIONS), trả về 200 luôn rồi kết thúc
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
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
        $product['HinhAnh'] = 'http://dientuonlineapi.byethost15.com/images/' . $product['HinhAnh'];
    }

    // Trả về danh sách sản phẩm dưới dạng JSON
    echo json_encode($products);
} catch (PDOException $e) {
    // Xử lý lỗi khi có vấn đề với truy vấn SQL
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi truy vấn: ' . $e->getMessage()]);
}
?>
