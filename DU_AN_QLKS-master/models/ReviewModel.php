<?php
require_once 'BaseModel.php';

class ReviewModel extends BaseModel {
    protected $table = 'reviews';

    public function __construct() {
        parent::__construct();
    }

    public function getRecentReviews($limit = 3) {
        $sql = "SELECT r.*, u.name as user_name, rm.name as room_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                JOIN rooms rm ON r.room_id = rm.id 
                ORDER BY r.created_at DESC 
                LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByRoomId($roomId) {
        $sql = "SELECT r.*, u.name as user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.room_id = ? 
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$roomId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomReviews($roomId) {
        $sql = "SELECT r.*, u.name as user_name, u.email as user_email
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                WHERE r.room_id = ?
                ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$roomId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO reviews (user_id, room_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['user_id'],
            $data['room_id'],
            $data['rating'],
            $data['comment']
        ]);
    }

    public function getAverageRating($roomId) {
        $sql = "SELECT AVG(rating) as average FROM reviews WHERE room_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$roomId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['average'] ?? 0;
    }

    public function createReview($data) {
        // Kiểm tra xem người dùng đã từng đặt phòng này chưa
        $bookingModel = new BookingModel();
        $hasBooked = $bookingModel->hasUserBookedRoom($data['user_id'], $data['room_id']);
        
        if (!$hasBooked) {
            return false;
        }

        return $this->create($data);
    }

    public function updateReview($reviewId, $data) {
        $sql = "UPDATE reviews SET rating = ?, comment = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['rating'],
            $data['comment'],
            $reviewId
        ]);
    }

    public function deleteReview($reviewId) {
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$reviewId]);
    }

    public function countTotalReviews() {
        $sql = "SELECT COUNT(*) as total FROM reviews";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function updateStatus($id, $status) {
        // Kiểm tra xem cột status có tồn tại không
        $checkColumn = "SHOW COLUMNS FROM reviews LIKE 'status'";
        $stmt = $this->conn->prepare($checkColumn);
        $stmt->execute();
        $columnExists = $stmt->rowCount() > 0;

        // Nếu cột không tồn tại, thêm nó vào
        if (!$columnExists) {
            $addColumn = "ALTER TABLE reviews ADD COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'";
            $this->conn->exec($addColumn);
        }

        // Cập nhật trạng thái
        $sql = "UPDATE reviews SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function getAll() {
        $sql = "SELECT r.*, u.name as user_name, rm.name as room_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                JOIN rooms rm ON r.room_id = rm.id 
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 