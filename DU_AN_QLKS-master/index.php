<?php
session_start();

// Load các file cấu hình
require_once 'config/config.php';
require_once 'config/database.php';

// Load các file cần thiết
require_once 'controllers/BaseController.php';
require_once 'models/BaseModel.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/RoomController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/BookingController.php';
require_once 'controllers/AdminController.php';

// Lấy action từ query string
$action = $_GET['act'] ?? 'home';

// Xử lý routing
switch ($action) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'rooms':
        $controller = new RoomController();
        $controller->index();
        break;

    case 'room-detail':
        $controller = new RoomController();
        $controller->show($_GET['id'] ?? 0);
        break;

    case 'room-search':
        $controller = new RoomController();
        $controller->search();
        break;

    case 'room-create':
        require_once 'controllers/RoomController.php';
        $controller = new RoomController();
        $controller->create();
        break;

    case 'room-edit':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once 'controllers/RoomController.php';
            $controller = new RoomController();
            $controller->edit($id);
        } else {
            header('Location: ' . BASE_URL . '?act=rooms');
        }
        break;

    case 'room-delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once 'controllers/RoomController.php';
            $controller = new RoomController();
            $controller->delete($id);
        } else {
            header('Location: ' . BASE_URL . '?act=rooms');
        }
        break;

    case 'room-status':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once 'controllers/RoomController.php';
            $controller = new RoomController();
            $controller->updateStatus($id);
        } else {
            header('Location: ' . BASE_URL . '?act=rooms');
        }
        break;

    case 'room-review':
        $id = $_GET['id'] ?? null;
        if ($id) {
            require_once 'controllers/RoomController.php';
            $controller = new RoomController();
            $controller->addReview($id);
        } else {
            header('Location: ' . BASE_URL . '?act=rooms');
        }
        break;

    case 'login':
        $controller = new UserController();
        $controller->login();
        break;

    case 'register':
        $controller = new UserController();
        $controller->register();
        break;

    case 'logout':
        $controller = new UserController();
        $controller->logout();
        break;

    case 'profile':
        $controller = new UserController();
        $controller->profile();
        break;

    case 'bookings':
        $controller = new BookingController();
        $controller->index();
        break;

    case 'booking-create':
        $controller = new BookingController();
        $controller->create();
        break;

    case 'booking-cancel':
        $controller = new BookingController();
        $controller->cancel($_GET['id'] ?? 0);
        break;

    case 'admin-dashboard':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;

    case 'admin-rooms':
        $controller = new AdminController();
        $controller->rooms();
        break;

    case 'admin-bookings':
        $controller = new AdminController();
        $controller->bookings();
        break;

    case 'admin-users':
        $controller = new AdminController();
        $controller->users();
        break;

    case 'admin-services':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->services();
        break;

    case 'admin-reviews':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reviews();
        break;

    case 'admin-settings':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->settings();
        break;

    case 'admin-reports':
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reports();
        break;

    case 'search':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->search();
        break;

    case 'about':
        require_once 'controllers/AboutController.php';
        $controller = new AboutController();
        $controller->index();
        break;

    case 'contact':
        require_once 'controllers/ContactController.php';
        $controller = new ContactController();
        $controller->index();
        break;

    case 'terms':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->terms();
        break;

    case 'privacy':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->privacy();
        break;

    case 'booking':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->booking();
        break;

    case 'my-bookings':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->myBookings();
        break;

    case 'services':
        require_once 'controllers/ServiceController.php';
        $controller = new ServiceController();
        $controller->index();
        break;

    default:
        // Hiển thị trang 404
        http_response_code(404);
        require_once 'views/404.php';
        break;
} 