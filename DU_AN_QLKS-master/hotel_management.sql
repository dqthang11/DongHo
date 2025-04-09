-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 04, 2025 lúc 12:43 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hotel_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_services`
--

CREATE TABLE `booking_services` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `room_id`, `rating`, `comment`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, 1, 5, 'Phòng rất đẹp và tiện nghi, nhân viên phục vụ nhiệt tình', '2025-04-04 07:36:30', '2025-04-04 08:32:12', 'approved'),
(2, 2, 2, 4, 'Phòng sạch sẽ, view đẹp, giá cả hợp lý', '2025-04-04 07:36:30', '2025-04-04 08:33:10', 'approved'),
(3, 2, 3, 3, 'Phòng ổn, đúng với giá tiền', '2025-04-04 07:36:30', '2025-04-04 08:33:11', 'approved');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bed_type` varchar(50) DEFAULT NULL,
  `max_guests` int(11) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `type`, `description`, `price`, `image`, `bed_type`, `max_guests`, `size`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Phòng Deluxe', 'deluxe', 'Phòng sang trọng với view đẹp', 1500000.00, 'deluxe.jpg', 'King', 2, '35m²', 'available', '2025-04-04 07:36:30', '2025-04-04 07:36:30'),
(2, 'Phòng Superior', 'superior', 'Phòng tiện nghi với đầy đủ tiện ích', 1200000.00, 'superior.jpg', 'Queen', 2, '30m²', 'available', '2025-04-04 07:36:30', '2025-04-04 07:36:30'),
(3, 'Phòng Standard', 'standard', 'Phòng tiêu chuẩn với giá hợp lý', 900000.00, 'standard.jpg', 'Double', 2, '25m²', 'available', '2025-04-04 07:36:30', '2025-04-04 07:36:30'),
(4, 'VIP Desert View Suite', 'vip', 'Phòng VIP sang trọng với tầm nhìn sa mạc tuyệt đẹp, thiết kế hiện đại, phòng tắm kính trong suốt và khu vực tiếp khách rộng rãi.', 5000000.00, 'vip-room.jpg', 'King Size', 4, '80', 'available', '2025-04-04 07:57:04', '2025-04-04 07:57:04'),
(5, 'Luxury Suite Room', 'suite', 'Phòng Suite sang trọng với nội thất cổ điển, sofa thoải mái, rèm cửa cao cấp và trang thiết bị hiện đại.', 3500000.00, 'suite-room.jpg', 'King Size', 3, '60', 'available', '2025-04-04 07:57:04', '2025-04-04 07:57:04'),
(6, 'Deluxe Ocean View', 'deluxe', 'Phòng Deluxe với tầm nhìn ra biển tuyệt đẹp, ban công riêng, nội thất hiện đại và tiện nghi cao cấp.', 2500000.00, 'deluxe-ocean-view.jpg', 'Queen Size', 2, '45', 'available', '2025-04-04 09:40:42', '2025-04-04 09:44:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `image_url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `details`, `price`, `status`, `image_url`, `image`, `created_at`, `updated_at`) VALUES
(22, 'Ăn sáng', 'Buffet sáng với nhiều món ngon', '• Buffet sáng đa dạng với các món ăn Việt Nam và quốc tế\n• Phục vụ từ 6:00 - 10:00 sáng\n• Được phục vụ tại nhà hàng chính của khách sạn\n• Bao gồm đồ uống không cồn', 200000.00, 'active', 'https://images.unsplash.com/photo-1555244162-803834f70033?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47'),
(23, 'Xe đưa đón sân bay', 'Dịch vụ đưa đón sân bay', '• Xe đời mới, lái xe chuyên nghiệp\n• Đón và trả khách tại sân bay\n• Phục vụ 24/7\n• Có thể đặt trước hoặc đặt ngay\n• Giá đã bao gồm phí cầu đường và bãi đỗ', 300000.00, 'active', 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47'),
(24, 'Massage', 'Dịch vụ massage thư giãn', '• Kỹ thuật viên massage chuyên nghiệp\n• Các liệu pháp massage đa dạng\n• Phòng massage riêng tư, sang trọng\n• Thời gian massage: 60 phút hoặc 90 phút\n• Có thể đặt lịch trước', 300000.00, 'active', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47'),
(25, 'Dịch vụ Giặt ủi', 'Dịch vụ giặt ủi chuyên nghiệp và nhanh chóng', '• Giặt ủi trong ngày\n• Giặt khô quần áo cao cấp\n• Phục vụ 24/7\n• Nhận và giao đồ tại phòng\n• Sử dụng hóa chất an toàn', 150000.00, 'active', 'https://sonhoianhotel.com/wp-content/uploads/2022/07/dic-vu-giat-say-lay-lien-tien-loi-3-1024x576.jpg', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47'),
(26, 'Dịch vụ Hồ bơi', 'Hồ bơi ngoài trời với view thành phố tuyệt đẹp', '• Hồ bơi vô cực\n• Phục vụ đồ uống tại hồ bơi\n• Ghế tắm nắng\n• Khăn tắm miễn phí\n• Phòng thay đồ riêng', 300000.00, 'active', 'https://images.unsplash.com/photo-1575429198097-0414ec08e8cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47'),
(27, 'Dịch vụ Phòng Gym', 'Phòng tập gym hiện đại với đầy đủ trang thiết bị', '• Thiết bị tập luyện hiện đại\n• HLV cá nhân\n• Phòng yoga\n• Phòng xông hơi\n• Phục vụ nước uống miễn phí', 200000.00, 'active', 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80', NULL, '2025-04-04 10:04:47', '2025-04-04 10:04:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@hotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-04-04 07:36:30', '2025-04-04 07:36:30'),
(2, 'User', 'user@hotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '2025-04-04 07:36:30', '2025-04-04 07:36:30'),
(3, 'Lê Văn Thế', 'lethe122005@gmail.com', '$2y$10$vu6zk86GQWkjCwoAbTNHF.ZSvbivyxFNSzfQ6JcVW6sbp3bUQfNJ6', 'user', '2025-04-04 07:40:30', '2025-04-04 07:40:30');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_room_name` (`name`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `booking_services_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `booking_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
