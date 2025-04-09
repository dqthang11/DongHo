<?php
require_once 'BaseController.php';
require_once 'models/UserModel.php';

class UserController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                $_SESSION['success'] = 'Đăng nhập thành công!';
                $this->redirect('/');
            } else {
                $_SESSION['error'] = 'Email hoặc mật khẩu không đúng.';
                $this->render('auth/login');
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Kiểm tra mật khẩu
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu không khớp.';
                $this->render('auth/register');
                return;
            }

            // Kiểm tra email đã tồn tại
            if ($this->userModel->getByEmail($email)) {
                $_SESSION['error'] = 'Email đã được sử dụng.';
                $this->render('auth/register');
                return;
            }

            // Tạo người dùng mới
            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user'
            ];

            if ($this->userModel->create($userData)) {
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                $this->redirect('/login');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
                $this->render('auth/register');
            }
        } else {
            $this->render('auth/register');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/');
    }

    public function profile() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem thông tin cá nhân.';
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Lấy thông tin người dùng hiện tại
            $user = $this->userModel->getById($_SESSION['user_id']);

            // Kiểm tra mật khẩu hiện tại
            if (!empty($currentPassword) && !password_verify($currentPassword, $user['password'])) {
                $_SESSION['error'] = 'Mật khẩu hiện tại không đúng.';
                $this->render('users/profile', ['user' => $user]);
                return;
            }

            // Kiểm tra mật khẩu mới
            if (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu mới không khớp.';
                $this->render('users/profile', ['user' => $user]);
                return;
            }

            // Cập nhật thông tin
            $userData = [
                'name' => $name,
                'email' => $email
            ];

            // Nếu có mật khẩu mới
            if (!empty($newPassword)) {
                $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            if ($this->userModel->update($_SESSION['user_id'], $userData)) {
                $_SESSION['success'] = 'Cập nhật thông tin thành công!';
                $_SESSION['user_name'] = $name;
                $this->redirect('/profile');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
                $this->render('users/profile', ['user' => $user]);
            }
        } else {
            $user = $this->userModel->getById($_SESSION['user_id']);
            $this->render('users/profile', ['user' => $user]);
        }
    }
} 