<?php
$host = 'trolley.proxy.rlwy.net';
$port = 29198;
$db   = 'railway';
$user = 'root';
$pass = 'HkufiVIsNjYOrCIhOeiSqTXbOGrCuDeM';
$charset = 'utf8mb4';

// Dùng cả host + port
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$pdo = null; // <-- thêm dòng này nếu chưa có

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Kết nối thất bại: ' . $e->getMessage()]);
    exit;
}
?>
