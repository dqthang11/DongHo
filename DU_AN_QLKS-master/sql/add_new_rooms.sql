-- Thêm phòng VIP mới
INSERT INTO rooms (name, type, description, price, status, bed_type, max_guests, size, image)
VALUES (
    'VIP Desert View Suite',
    'vip',
    'Phòng VIP sang trọng với tầm nhìn sa mạc tuyệt đẹp, thiết kế hiện đại, phòng tắm kính trong suốt và khu vực tiếp khách rộng rãi.',
    5000000,
    'available',
    'King Size',
    4,
    80,
    'vip-room.jpg'
);

-- Thêm phòng Suite mới
INSERT INTO rooms (name, type, description, price, status, bed_type, max_guests, size, image)
VALUES (
    'Luxury Suite Room',
    'suite',
    'Phòng Suite sang trọng với nội thất cổ điển, sofa thoải mái, rèm cửa cao cấp và trang thiết bị hiện đại.',
    3500000,
    'available',
    'King Size',
    3,
    60,
    'suite-room.jpg'
);

-- Thêm phòng Deluxe mới
INSERT INTO rooms (name, type, description, price, status, bed_type, max_guests, size, image)
VALUES (
    'Deluxe Ocean View',
    'deluxe',
    'Phòng Deluxe với tầm nhìn ra biển tuyệt đẹp, ban công riêng, nội thất hiện đại và tiện nghi cao cấp.',
    2500000,
    'available',
    'Queen Size',
    2,
    45,
    'deluxe-ocean.jpg'
); 