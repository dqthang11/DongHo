<?php
require_once 'BaseController.php';
require_once 'models/RoomModel.php';
require_once 'models/BookingModel.php';
require_once 'models/ReviewModel.php';
require_once 'models/ServiceModel.php';

class RoomController extends BaseController {
    private $roomModel;
    private $bookingModel;
    private $reviewModel;
    private $serviceModel;

    public function __construct() {
        $this->roomModel = new RoomModel();
        $this->bookingModel = new BookingModel();
        $this->reviewModel = new ReviewModel();
        $this->serviceModel = new ServiceModel();
    }

    public function index() {
        // Lấy danh sách phòng và loại phòng
        $rooms = $this->roomModel->getAll();
        $roomTypes = $this->roomModel->getRoomTypes();

        // Debug: In ra số lượng phòng
        echo "<!-- Debug: Số lượng phòng = " . count($rooms) . " -->";
        
        // Debug: In ra thông tin phòng
        echo "<!-- Debug: Thông tin phòng = " . print_r($rooms, true) . " -->";

        $this->render('rooms/index', [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes
        ]);
    }

    public function show($id) {
        $room = $this->roomModel->getById($id);
        if (!$room) {
            $_SESSION['error'] = 'Không tìm thấy phòng.';
            $this->redirect('/rooms');
        }

        // Lấy đánh giá của phòng
        $reviews = $this->reviewModel->getRoomReviews($id);

        // Lấy các phòng tương tự
        $similarRooms = $this->roomModel->getSimilarRooms($id, $room['type'], 3);

        // Lấy danh sách dịch vụ
        $services = $this->serviceModel->getAll();

        $this->render('rooms/show', [
            'room' => $room,
            'reviews' => $reviews,
            'similarRooms' => $similarRooms,
            'services' => $services
        ]);
    }

    public function search() {
        // Xử lý khoảng giá
        $priceRange = $_GET['price_range'] ?? '';
        $minPrice = '';
        $maxPrice = '';
        if ($priceRange) {
            list($minPrice, $maxPrice) = explode('-', $priceRange);
        }

        $filters = [
            'type' => $_GET['type'] ?? '',
            'min_price' => $minPrice,
            'max_price' => $maxPrice
        ];

        // Lấy danh sách phòng theo bộ lọc
        $rooms = $this->roomModel->search($filters['type'], $filters['min_price'], $filters['max_price']);
        
        // Lấy danh sách loại phòng cho dropdown
        $roomTypes = $this->roomModel->getRoomTypes();

        // Debug: In ra thông tin tìm kiếm
        echo "<!-- Debug: Filters = " . print_r($filters, true) . " -->";
        echo "<!-- Debug: Số lượng phòng tìm được = " . count($rooms) . " -->";

        $this->render('rooms/index', [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
            'filters' => $filters
        ]);
    }

    public function create() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRequest(['name', 'type', 'price', 'description']);
            
            if (empty($errors)) {
                $roomData = [
                    'name' => $_POST['name'],
                    'type' => $_POST['type'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'amenities' => $_POST['amenities'] ?? [],
                    'status' => ROOM_STATUS_AVAILABLE
                ];

                if ($this->roomModel->create($roomData)) {
                    $_SESSION['success'] = 'Thêm phòng thành công!';
                    $this->redirect('/admin/rooms');
                } else {
                    $errors['general'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->render('admin/rooms/create', [
                'errors' => $errors,
                'roomTypes' => $this->roomModel->getRoomTypes()
            ]);
        } else {
            $this->render('admin/rooms/create', [
                'roomTypes' => $this->roomModel->getRoomTypes()
            ]);
        }
    }

    public function edit($id) {
        $this->requireAdmin();

        $room = $this->roomModel->getById($id);
        if (!$room) {
            $_SESSION['error'] = 'Không tìm thấy phòng.';
            $this->redirect('/admin/rooms');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRequest(['name', 'type', 'price', 'description']);
            
            if (empty($errors)) {
                $roomData = [
                    'name' => $_POST['name'],
                    'type' => $_POST['type'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'amenities' => $_POST['amenities'] ?? [],
                    'status' => $_POST['status']
                ];

                if ($this->roomModel->update($id, $roomData)) {
                    $_SESSION['success'] = 'Cập nhật phòng thành công!';
                    $this->redirect('/admin/rooms');
                } else {
                    $errors['general'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $this->render('admin/rooms/edit', [
                'room' => $room,
                'errors' => $errors,
                'roomTypes' => $this->roomModel->getRoomTypes()
            ]);
        } else {
            $this->render('admin/rooms/edit', [
                'room' => $room,
                'roomTypes' => $this->roomModel->getRoomTypes()
            ]);
        }
    }

    public function delete($id) {
        $this->requireAdmin();

        $room = $this->roomModel->getById($id);
        if (!$room) {
            $_SESSION['error'] = 'Không tìm thấy phòng.';
            $this->redirect('/admin/rooms');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->roomModel->delete($id)) {
                $_SESSION['success'] = 'Xóa phòng thành công!';
                $this->redirect('/admin/rooms');
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
            }
        }

        $this->render('admin/rooms/delete', ['room' => $room]);
    }

    public function updateStatus($id) {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            
            if (in_array($status, [
                ROOM_STATUS_AVAILABLE,
                ROOM_STATUS_BOOKED,
                ROOM_STATUS_MAINTENANCE
            ])) {
                if ($this->roomModel->updateStatus($id, $status)) {
                    $_SESSION['success'] = 'Cập nhật trạng thái phòng thành công!';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }

        $this->redirect('/admin/rooms');
    }

    public function addReview($id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đánh giá phòng.';
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRequest(['rating', 'comment']);
            
            if (empty($errors)) {
                $reviewData = [
                    'user_id' => $_SESSION['user_id'],
                    'room_id' => $id,
                    'rating' => $_POST['rating'],
                    'comment' => $_POST['comment'],
                    'status' => 'pending'
                ];

                if ($this->reviewModel->create($reviewData)) {
                    $_SESSION['success'] = 'Cảm ơn bạn đã đánh giá phòng!';
                    $this->redirect("/rooms/$id");
                } else {
                    $errors['general'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $room = $this->roomModel->getById($id);
            $this->render('rooms/review', [
                'room' => $room,
                'errors' => $errors
            ]);
        } else {
            $room = $this->roomModel->getById($id);
            $this->render('rooms/review', ['room' => $room]);
        }
    }
}
