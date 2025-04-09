<?php
require_once 'BaseModel.php';

class RoomModel extends BaseModel {
    protected $table = 'rooms';

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $sql = "SELECT * FROM rooms ORDER BY price DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableRooms($checkIn, $checkOut) {
        $sql = "SELECT r.* FROM rooms r 
                WHERE r.status = 'available' 
                AND r.id NOT IN (
                    SELECT room_id FROM bookings 
                    WHERE status != 'cancelled' 
                    AND (
                        (check_in <= ? AND check_out >= ?)
                        OR (check_in <= ? AND check_out >= ?)
                        OR (check_in >= ? AND check_out <= ?)
                    )
                )";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$checkIn, $checkIn, $checkOut, $checkOut, $checkIn, $checkOut]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomsByType($type) {
        $query = "SELECT * FROM " . $this->table . " WHERE type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomsByPriceRange($minPrice, $maxPrice) {
        $query = "SELECT * FROM " . $this->table . " WHERE price BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$minPrice, $maxPrice]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRoomStatus($roomId, $status) {
        $query = "UPDATE " . $this->table . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $roomId]);
    }

    public function searchRooms($filters) {
        $sql = "SELECT DISTINCT r.* FROM rooms r WHERE r.status = 'available'";
        $params = [];

        // Lọc theo loại phòng
        if (!empty($filters['type'])) {
            $sql .= " AND r.type = ?";
            $params[] = $filters['type'];
        }

        // Lọc theo khoảng giá
        if (!empty($filters['min_price'])) {
            $sql .= " AND r.price >= ?";
            $params[] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND r.price <= ?";
            $params[] = $filters['max_price'];
        }

        // Lọc theo ngày đặt phòng
        if (!empty($filters['check_in']) && !empty($filters['check_out'])) {
            $sql .= " AND r.id NOT IN (
                SELECT b.room_id FROM bookings b 
                WHERE b.status NOT IN ('cancelled', 'rejected')
                AND (
                    (b.check_in <= ? AND b.check_out >= ?)
                    OR (b.check_in <= ? AND b.check_out >= ?)
                    OR (b.check_in >= ? AND b.check_out <= ?)
                )
            )";
            $params = array_merge($params, [
                $filters['check_in'], $filters['check_in'],
                $filters['check_out'], $filters['check_out'],
                $filters['check_in'], $filters['check_out']
            ]);
        }

        // Sắp xếp kết quả
        $sql .= " ORDER BY r.price ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi tìm kiếm phòng: " . $e->getMessage());
            return [];
        }
    }

    public function getFeaturedRooms($limit = 6) {
        $sql = "SELECT * FROM rooms WHERE status = 'available' ORDER BY price DESC LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomTypes() {
        $sql = "SELECT DISTINCT type FROM rooms ORDER BY type";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function countTotalRooms() {
        $sql = "SELECT COUNT(*) as total FROM rooms";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function countTotalBookings() {
        $sql = "SELECT COUNT(*) as total FROM bookings WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getRoomStats() {
        $sql = "SELECT r.type,
                COUNT(*) as total_rooms,
                COUNT(CASE WHEN r.status = 'available' THEN 1 END) as available_rooms,
                COUNT(CASE WHEN r.status = 'booked' THEN 1 END) as booked_rooms,
                COUNT(CASE WHEN r.status = 'maintenance' THEN 1 END) as maintenance_rooms,
                AVG(r.price) as avg_price
                FROM rooms r
                GROUP BY r.type";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSimilarRooms($roomId, $roomType, $limit = 3) {
        $sql = "SELECT * FROM rooms 
                WHERE type = ? 
                AND id != ? 
                AND status = 'available' 
                LIMIT " . (int)$limit;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$roomType, $roomId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE rooms SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function search($type = null, $minPrice = null, $maxPrice = null) {
        $sql = "SELECT * FROM rooms WHERE status = 'available'";
        $params = [];

        if ($type) {
            $sql .= " AND type = ?";
            $params[] = $type;
        }

        if ($minPrice !== null && $minPrice !== '') {
            $sql .= " AND price >= ?";
            $params[] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $sql .= " AND price <= ?";
            $params[] = $maxPrice;
        }

        $sql .= " ORDER BY price ASC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi tìm kiếm phòng: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM rooms WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByType($type) {
        $sql = "SELECT * FROM rooms WHERE type = ? AND status = 'available'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 