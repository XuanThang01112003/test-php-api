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

// Khởi động session và kết nối DB sau khi xử lý CORS
session_start();
require_once('../config/database.php');
require_once('../config/dbhelper.php');

$db = new Db(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['TenDangNhap'];
    $password = $_POST['MatKhau'];

    $sql_check_user = "SELECT * FROM nguoidung WHERE TenDangNhap = :TenDangNhap AND MatKhau = :MatKhau";
    $result = $db->select($sql_check_user, ['TenDangNhap' => $ten_dang_nhap, 'MatKhau' => $password]);

    if (count($result) > 0) {
        $user = $result[0];
        $_SESSION['user_nguoidung'] = $user['TenDangNhap'];
        $_SESSION['user_id'] = $user['MaNguoiDung'];

        echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công', 'redirect' => '/']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Thông tin đăng nhập không hợp lệ.']);
    }
}
?>
