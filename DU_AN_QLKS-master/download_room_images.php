<?php
// Mảng chứa URL ảnh cho từng loại phòng
$roomImages = [
    'standard-room.jpg' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304',
    'deluxe-room.jpg' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39',
    'suite-room.jpg' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427',
    'vip-room.jpg' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461',
    'default.jpg' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a'
];

// Tạo thư mục nếu chưa tồn tại
$targetDir = __DIR__ . '/assets/images/rooms';
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Tải và lưu từng ảnh
foreach ($roomImages as $filename => $url) {
    $targetFile = $targetDir . '/' . $filename;
    
    // Tải ảnh
    $imageContent = file_get_contents($url);
    if ($imageContent !== false) {
        // Lưu ảnh
        if (file_put_contents($targetFile, $imageContent) !== false) {
            echo "Đã tải thành công: $filename\n";
        } else {
            echo "Lỗi khi lưu: $filename\n";
        }
    } else {
        echo "Lỗi khi tải: $filename\n";
    }
}

echo "Hoàn thành tải ảnh!\n"; 