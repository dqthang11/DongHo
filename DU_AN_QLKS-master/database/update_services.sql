-- Chọn database
USE hotel_management;

-- Xóa dữ liệu trong bảng booking_services trước
DELETE FROM booking_services;

-- Sau đó mới xóa dữ liệu trong bảng services
DELETE FROM services;

-- Thêm cột image_url vào bảng services nếu chưa có
ALTER TABLE services ADD COLUMN IF NOT EXISTS image_url VARCHAR(255) AFTER price;

-- Thêm cột status vào bảng services nếu chưa có
ALTER TABLE services ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive') DEFAULT 'active' AFTER price;

-- Thêm cột details vào bảng services nếu chưa có
ALTER TABLE services ADD COLUMN IF NOT EXISTS details TEXT AFTER description;

-- Thêm các dịch vụ mới
INSERT INTO services (name, description, price, image_url, status, details) VALUES
(
    'Ăn sáng',
    'Buffet sáng với nhiều món ngon',
    200000,
    'https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
    'active',
    '• Buffet sáng đa dạng với các món ăn Việt Nam và quốc tế\n• Phục vụ từ 6:00 - 10:00 sáng\n• Được phục vụ tại nhà hàng chính của khách sạn\n• Bao gồm đồ uống không cồn'
),
(
    'Xe đưa đón sân bay',
    'Dịch vụ đưa đón sân bay',
    300000,
    'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80',
    'active',
    '• Xe đời mới, lái xe chuyên nghiệp\n• Đón và trả khách tại sân bay\n• Phục vụ 24/7\n• Có thể đặt trước hoặc đặt ngay\n• Giá đã bao gồm phí cầu đường và bãi đỗ'
),
(
    'Massage',
    'Dịch vụ massage thư giãn',
    300000,
    'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
    'active',
    '• Kỹ thuật viên massage chuyên nghiệp\n• Các liệu pháp massage đa dạng\n• Phòng massage riêng tư, sang trọng\n• Thời gian massage: 60 phút hoặc 90 phút\n• Có thể đặt lịch trước'
),
(
    'Dịch vụ Giặt ủi',
    'Dịch vụ giặt ủi chuyên nghiệp và nhanh chóng',
    150000,
    'https://sonhoianhotel.com/wp-content/uploads/2022/07/dic-vu-giat-say-lay-lien-tien-loi-3-1024x576.jpg',
    'active',
    '• Giặt ủi trong ngày\n• Giặt khô quần áo cao cấp\n• Phục vụ 24/7\n• Nhận và giao đồ tại phòng\n• Sử dụng hóa chất an toàn'
),
(
    'Dịch vụ Hồ bơi',
    'Hồ bơi ngoài trời với view thành phố tuyệt đẹp',
    300000,
    'https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
    'active',
    '• Hồ bơi vô cực\n• Phục vụ đồ uống tại hồ bơi\n• Ghế tắm nắng\n• Khăn tắm miễn phí\n• Phòng thay đồ riêng'
),
(
    'Dịch vụ Phòng Gym',
    'Phòng tập gym hiện đại với đầy đủ trang thiết bị',
    200000,
    'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
    'active',
    '• Thiết bị tập luyện hiện đại\n• HLV cá nhân\n• Phòng yoga\n• Phòng xông hơi\n• Phục vụ nước uống miễn phí'
);

-- Hiển thị kết quả
SELECT id, name, description, price, image_url, status, details FROM services; 