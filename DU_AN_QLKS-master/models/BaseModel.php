<?php
class BaseModel {
    protected $conn;
    protected $table;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=hotel_management;charset=utf8mb4",
                "root",
                ""
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($fields) - 1) . '?';
        
        $query = "INSERT INTO " . $this->table . " (" . implode(',', $fields) . ") VALUES (" . $placeholders . ")";
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute($values);
    }

    public function update($id, $data) {
        $fields = array_keys($data);
        $values = array_values($data);
        $set = implode('=?,', $fields) . '=?';
        
        $query = "UPDATE " . $this->table . " SET " . $set . " WHERE id = ?";
        $values[] = $id;
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($values);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollback() {
        return $this->conn->rollBack();
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE " . $this->table . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    public function updateBookingStatus($id, $status) {
        return $this->updateStatus($id, $status);
    }
} 