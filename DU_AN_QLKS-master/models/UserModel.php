<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function authenticate($email, $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = ?, email = ?";
        $params = [$data['name'], $data['email']];

        if (isset($data['password'])) {
            $sql .= ", password = ?";
            $params[] = $data['password'];
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $password) {
        $query = "UPDATE " . $this->table . " SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            password_hash($password, PASSWORD_DEFAULT),
            $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        // Mã hóa mật khẩu
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function getUsersByRole($role) {
        $query = "SELECT * FROM " . $this->table . " WHERE role = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveResetToken($userId, $token, $expires) {
        $query = "UPDATE " . $this->table . " 
                  SET reset_token = ?, reset_token_expires = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$token, $expires, $userId]);
    }

    public function validateResetToken($token) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE reset_token = ? 
                  AND reset_token_expires > NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            // Xóa token sau khi sử dụng
            $this->clearResetToken($result['id']);
            return $result['id'];
        }
        
        return false;
    }

    private function clearResetToken($userId) {
        $query = "UPDATE " . $this->table . " 
                  SET reset_token = NULL, reset_token_expires = NULL 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId]);
    }

    public function countTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Thêm phương thức để lấy danh sách cột của bảng
    private function getTableColumns() {
        $sql = "SHOW COLUMNS FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }
} 