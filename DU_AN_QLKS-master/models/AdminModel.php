<?php
require_once 'BaseModel.php';

class AdminModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    public function getDashboardStats() {
        $stats = [];

        // Tổng số phòng
        $sql = "SELECT COUNT(*) as total FROM rooms";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_rooms'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Tổng số đặt phòng
        $sql = "SELECT COUNT(*) as total FROM bookings";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Tổng số người dùng
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Doanh thu tháng này
        $sql = "SELECT SUM(total_price) as total FROM bookings 
                WHERE status = 'confirmed' 
                AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stats['monthly_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return $stats;
    }

    public function getRecentBookings($limit = 5) {
        $sql = "SELECT b.*, u.name as user_name, r.name as room_name 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                ORDER BY b.created_at DESC 
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomOccupancy() {
        $sql = "SELECT r.type, 
                COUNT(*) as total_rooms,
                SUM(CASE WHEN r.status = 'booked' THEN 1 ELSE 0 END) as booked_rooms
                FROM rooms r 
                GROUP BY r.type";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 