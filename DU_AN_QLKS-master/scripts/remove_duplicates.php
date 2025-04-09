<?php
require_once __DIR__ . '/../config/database.php';

// Khởi tạo kết nối database
$database = new Database();
$conn = $database->getConnection();

// Đọc nội dung file SQL
$sql = file_get_contents(__DIR__ . '/../sql/remove_duplicate_rooms.sql');

try {
    // Thực thi các câu lệnh SQL
    $result = $conn->exec($sql);
    
    if ($result !== false) {
        echo "Đã xóa thành công các phòng trùng lặp!\n";
    } else {
        echo "Có lỗi xảy ra khi xóa phòng trùng lặp.\n";
    }
} catch (PDOException $e) {
    echo "Lỗi SQL: " . $e->getMessage() . "\n";
} 