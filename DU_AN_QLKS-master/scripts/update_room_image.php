<?php
require_once __DIR__ . '/../config/database.php';

// Khởi tạo kết nối database
$database = new Database();
$conn = $database->getConnection();

// URL ảnh
$imageUrl = 'https://pix8.agoda.net/hotelImages/124/1246280/1246280_16061017110043391702.jpg?ca=6&ce=1&s=1024x768';
$imageName = 'deluxe-ocean-view.jpg';
$imagePath = __DIR__ . '/../assets/images/rooms/' . $imageName;

// Tải ảnh về
if (!file_exists(dirname($imagePath))) {
    mkdir(dirname($imagePath), 0777, true);
}

if (file_put_contents($imagePath, file_get_contents($imageUrl))) {
    echo "Đã tải ảnh thành công!\n";
    
    // Cập nhật tên file ảnh trong database
    $sql = "UPDATE rooms SET image = ? WHERE name = 'Deluxe Ocean View'";
    try {
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$imageName])) {
            echo "Đã cập nhật ảnh trong database thành công!\n";
        } else {
            echo "Có lỗi xảy ra khi cập nhật database.\n";
        }
    } catch (PDOException $e) {
        echo "Lỗi SQL: " . $e->getMessage() . "\n";
    }
} else {
    echo "Có lỗi xảy ra khi tải ảnh.\n";
} 