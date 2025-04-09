<?php
require_once __DIR__ . '/../config/database.php';

// Khởi tạo kết nối database
$database = new Database();
$conn = $database->getConnection();

// Đọc nội dung file SQL
$sql = file_get_contents(__DIR__ . '/../sql/add_new_rooms.sql');

try {
    // Thực thi các câu lệnh SQL
    $result = $conn->exec($sql);
    
    if ($result !== false) {
        echo "Đã thêm thành công các phòng mới!\n";
    } else {
        echo "Có lỗi xảy ra khi thêm phòng.\n";
    }
} catch (PDOException $e) {
    echo "Lỗi SQL: " . $e->getMessage() . "\n";
} 