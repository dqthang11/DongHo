<?php
require_once 'BaseModel.php';

class ServiceModel extends BaseModel {
    protected $table = 'services';

    public function __construct() {
        parent::__construct();
    }

    public function getActiveServices() {
        $sql = "SELECT * FROM services ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $sql = "SELECT id, name, description, price, image_url, status FROM services ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT id, name, description, price, image_url, status FROM services WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO services (name, description, price, image_url, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image_url'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE services SET name = ?, description = ?, price = ?, image_url = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['image_url'] ?? null,
            $data['status'] ?? 'active',
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM services WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getUserBookings($userId) {
        $sql = "SELECT b.*, r.name as room_name, r.image as room_image 
                FROM bookings b 
                JOIN rooms r ON b.room_id = r.id 
                WHERE b.user_id = ? AND b.status != 'cancelled'
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceOrder($orderId) {
        $sql = "SELECT * FROM service_orders WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getServiceOrders($bookingId) {
        $sql = "SELECT so.*, s.name as service_name, s.price as service_price 
                FROM service_orders so 
                JOIN services s ON so.service_id = s.id 
                WHERE so.booking_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createServiceOrder($data) {
        $sql = "INSERT INTO service_orders (service_id, booking_id, quantity, total_price, status) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['service_id'],
            $data['booking_id'],
            $data['quantity'],
            $data['total_price'],
            $data['status']
        ]);
    }

    public function updateServiceStatus($orderId, $status) {
        $sql = "UPDATE service_orders SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $orderId]);
    }

    public function createReview($data) {
        $sql = "INSERT INTO service_reviews (service_id, user_id, rating, comment) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['service_id'],
            $data['user_id'],
            $data['rating'],
            $data['comment']
        ]);
    }

    public function getAllOrders() {
        $sql = "SELECT so.*, s.name as service_name, s.price as service_price,
                b.user_id, b.check_in, b.check_out,
                u.name as user_name, u.email as user_email
                FROM service_orders so
                JOIN services s ON so.service_id = s.id
                JOIN bookings b ON so.booking_id = b.id
                JOIN users u ON b.user_id = u.id
                ORDER BY so.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceRevenue($startDate, $endDate) {
        $query = "SELECT s.name, COUNT(so.id) as total_orders, 
                  SUM(so.total_price) as total_revenue 
                  FROM " . $this->table . " s 
                  LEFT JOIN service_orders so ON s.id = so.service_id 
                  WHERE so.created_at BETWEEN ? AND ? 
                  AND so.status = 'completed' 
                  GROUP BY s.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceStats() {
        $sql = "SELECT 
                COUNT(*) as total_services,
                SUM(price) as total_value,
                AVG(price) as avg_price
                FROM services";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countTotalServices() {
        $sql = "SELECT COUNT(*) as total FROM services";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getByBooking($bookingId) {
        $sql = "SELECT s.*, bs.quantity 
                FROM services s 
                JOIN booking_services bs ON s.id = bs.service_id 
                WHERE bs.booking_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByBookingId($bookingId) {
        $sql = "SELECT s.*, bs.quantity 
                FROM services s
                JOIN booking_services bs ON s.id = bs.service_id
                WHERE bs.booking_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPopularServices($limit = 5) {
        $sql = "SELECT s.*, COUNT(bs.id) as booking_count
                FROM services s
                LEFT JOIN booking_services bs ON s.id = bs.service_id
                GROUP BY s.id
                ORDER BY booking_count DESC
                LIMIT " . (int)$limit;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServicesByType($type) {
        $sql = "SELECT * FROM services WHERE type = ? ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $sql = "SELECT * FROM services 
                WHERE name LIKE ? OR description LIKE ? 
                ORDER BY name";
        
        $keyword = "%$keyword%";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceTypes() {
        $sql = "SELECT DISTINCT type FROM services ORDER BY type";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getMonthlyRevenue() {
        $sql = "SELECT 
                DATE_FORMAT(bs.created_at, '%Y-%m') as month,
                SUM(s.price * bs.quantity) as revenue
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.id
                GROUP BY month
                ORDER BY month DESC
                LIMIT 12";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 