<?php
require_once 'BaseModel.php';

class BookingModel extends BaseModel {
    protected $table = 'bookings';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $sql = "INSERT INTO bookings (user_id, room_id, check_in, check_out, guests, total_price, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['user_id'],
            $data['room_id'],
            $data['check_in'],
            $data['check_out'],
            $data['guests'],
            $data['total_price'],
            $data['status']
        ]);
        
        return $this->conn->lastInsertId();
    }

    public function getById($id) {
        $sql = "SELECT b.*, r.name as room_name, r.price as room_price, r.type as room_type,
                u.name as user_name, u.email as user_email
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                JOIN users u ON b.user_id = u.id
                WHERE b.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId) {
        $sql = "SELECT b.*, r.name as room_name, r.price as room_price, r.type as room_type,
                r.image as room_image
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function getBookingsByDateRange($startDate, $endDate) {
        $sql = "SELECT b.*, r.name as room_name, r.type as room_type,
                u.name as user_name
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                JOIN users u ON b.user_id = u.id
                WHERE b.check_in BETWEEN ? AND ?
                OR b.check_out BETWEEN ? AND ?
                ORDER BY b.check_in";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingStats() {
        $sql = "SELECT 
                COUNT(*) as total_bookings,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_bookings,
                COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_bookings,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_bookings,
                COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_bookings,
                SUM(CASE WHEN status = 'completed' THEN total_price ELSE 0 END) as total_revenue
                FROM bookings";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countTotalBookings() {
        $sql = "SELECT COUNT(*) as total FROM bookings WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getRecentBookings($limit = 5) {
        $sql = "SELECT b.*, r.name as room_name, u.name as user_name
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC
                LIMIT " . (int)$limit;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingServices($bookingId) {
        $sql = "SELECT bs.*, s.name as service_name, s.price as service_price
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.id
                WHERE bs.booking_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBookingService($bookingId, $serviceId, $quantity) {
        $sql = "INSERT INTO booking_services (booking_id, service_id, quantity) 
                VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$bookingId, $serviceId, $quantity]);
    }

    public function removeBookingService($bookingId, $serviceId) {
        $sql = "DELETE FROM booking_services 
                WHERE booking_id = ? AND service_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$bookingId, $serviceId]);
    }

    public function isRoomAvailable($roomId, $checkIn, $checkOut) {
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE room_id = ? 
                AND status != 'cancelled'
                AND (
                    (check_in <= ? AND check_out >= ?)
                    OR (check_in <= ? AND check_out >= ?)
                    OR (check_in >= ? AND check_out <= ?)
                )";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$roomId, $checkIn, $checkIn, $checkOut, $checkOut, $checkIn, $checkOut]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }

    public function createBooking($data) {
        // Tính toán tổng giá
        $roomModel = new RoomModel();
        $room = $roomModel->getById($data['room_id']);
        
        $checkIn = new DateTime($data['check_in']);
        $checkOut = new DateTime($data['check_out']);
        $days = $checkOut->diff($checkIn)->days;
        
        $data['total_amount'] = $room['price'] * $days;
        return $this->create($data);
    }

    public function getUserBookings($userId) {
        $sql = "SELECT b.*, r.name as room_name, r.type as room_type,
                r.image as room_image
                FROM bookings b
                JOIN rooms r ON b.room_id = r.id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingDetails($bookingId) {
        $query = "SELECT b.*, r.name as room_name, r.type as room_type, 
                  u.name as user_name, u.email as user_email 
                  FROM " . $this->table . " b 
                  JOIN rooms r ON b.room_id = r.id 
                  JOIN users u ON b.user_id = u.id 
                  WHERE b.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$bookingId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMonthlyBookings($month, $year) {
        $query = "SELECT COUNT(*) as total_bookings, SUM(total_amount) as total_revenue 
                  FROM " . $this->table . " 
                  WHERE MONTH(created_at) = ? AND YEAR(created_at) = ? 
                  AND status = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$month, $year, BOOKING_STATUS_COMPLETED]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasUserBookedRoom($userId, $roomId) {
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE user_id = ? AND room_id = ? AND status = 'completed'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $roomId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function getTotalRevenue() {
        $sql = "SELECT SUM(total_amount) as total FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => BOOKING_STATUS_COMPLETED]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getMonthlyStats() {
        $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    COUNT(*) as total_bookings,
                    SUM(total_amount) as total_revenue
                FROM " . $this->table . " 
                WHERE status = :status
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month DESC
                LIMIT 12";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => BOOKING_STATUS_COMPLETED]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $sql = "SELECT b.*, r.name as room_name, u.name as user_name 
                FROM " . $this->table . " b 
                JOIN rooms r ON b.room_id = r.id 
                JOIN users u ON b.user_id = u.id 
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 