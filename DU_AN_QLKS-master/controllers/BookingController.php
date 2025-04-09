<?php
require_once 'BaseController.php';
require_once 'models/BookingModel.php';
require_once 'models/RoomModel.php';
require_once 'models/ServiceModel.php';

class BookingController extends BaseController {
    private $bookingModel;
    private $roomModel;
    private $serviceModel;

    public function __construct() {
        $this->bookingModel = new BookingModel();
        $this->roomModel = new RoomModel();
        $this->serviceModel = new ServiceModel();
    }

    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem đặt phòng.';
            $this->redirect('/login');
        }

        // Lấy danh sách đặt phòng của người dùng
        $bookings = $this->bookingModel->getUserBookings($_SESSION['user_id']);

        $this->render('bookings/index', [
            'bookings' => $bookings
        ]);
    }

    public function create() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đặt phòng.';
            $this->redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate dữ liệu đầu vào
            $roomId = $_POST['room_id'] ?? 0;
            $checkIn = $_POST['check_in'] ?? '';
            $checkOut = $_POST['check_out'] ?? '';
            $guests = $_POST['guests'] ?? 1;
            $services = $_POST['services'] ?? [];

            // Validate ngày check-in và check-out
            $checkInDate = new DateTime($checkIn);
            $checkOutDate = new DateTime($checkOut);
            $today = new DateTime();

            if ($checkInDate < $today) {
                $_SESSION['error'] = 'Ngày nhận phòng không thể là ngày trong quá khứ.';
                $this->redirect("/rooms/{$roomId}");
                return;
            }

            if ($checkOutDate <= $checkInDate) {
                $_SESSION['error'] = 'Ngày trả phòng phải sau ngày nhận phòng.';
                $this->redirect("/rooms/{$roomId}");
                return;
            }

            // Kiểm tra phòng có tồn tại và sẵn sàng không
            $room = $this->roomModel->getById($roomId);
            if (!$room) {
                $_SESSION['error'] = 'Không tìm thấy phòng.';
                $this->redirect('/rooms');
                return;
            }

            // Kiểm tra phòng có đủ chỗ cho số khách không
            if ($guests > $room['max_guests']) {
                $_SESSION['error'] = 'Số lượng khách vượt quá sức chứa của phòng.';
                $this->redirect("/rooms/{$roomId}");
                return;
            }

            // Kiểm tra phòng có sẵn sàng cho thời gian đặt không
            if (!$this->bookingModel->isRoomAvailable($roomId, $checkIn, $checkOut)) {
                $_SESSION['error'] = 'Phòng đã được đặt trong khoảng thời gian này.';
                $this->redirect("/rooms/{$roomId}");
                return;
            }

            try {
                // Bắt đầu transaction
                $this->bookingModel->beginTransaction();

                // Tính tổng giá
                $totalPrice = $this->calculateTotalPrice($room, $checkIn, $checkOut, $services);

                // Tạo đặt phòng
                $bookingData = [
                    'user_id' => $_SESSION['user_id'],
                    'room_id' => $roomId,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'guests' => $guests,
                    'total_price' => $totalPrice,
                    'status' => 'pending'
                ];

                // Tạo booking và lấy ID
                $bookingId = $this->bookingModel->create($bookingData);

                if (!$bookingId) {
                    throw new Exception('Không thể tạo đặt phòng.');
                }

                // Thêm các dịch vụ nếu có
                if (!empty($services)) {
                    foreach ($services as $serviceId) {
                        $this->bookingModel->addBookingService($bookingId, $serviceId, 1);
                    }
                }

                // Cập nhật trạng thái phòng
                $this->roomModel->updateStatus($roomId, 'booked');

                // Commit transaction
                $this->bookingModel->commit();

                $_SESSION['success'] = 'Đặt phòng thành công! Vui lòng chờ xác nhận từ khách sạn.';
                $this->redirect('/bookings');

            } catch (Exception $e) {
                // Rollback nếu có lỗi
                $this->bookingModel->rollback();
                error_log("Lỗi đặt phòng: " . $e->getMessage());
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
                $this->redirect("/rooms/{$roomId}");
            }
        }
    }

    public function cancel($id) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để hủy đặt phòng.';
            $this->redirect('/login');
        }

        // Kiểm tra quyền sở hữu
        $booking = $this->bookingModel->getById($id);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không tìm thấy đặt phòng.';
            $this->redirect('/bookings');
        }

        // Hủy đặt phòng
        if ($this->bookingModel->updateStatus($id, 'cancelled')) {
            $_SESSION['success'] = 'Hủy đặt phòng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
        }

        $this->redirect('/bookings');
    }

    private function calculateTotalPrice($room, $checkIn, $checkOut, $services) {
        // Tính số ngày
        $checkInDate = new DateTime($checkIn);
        $checkOutDate = new DateTime($checkOut);
        $days = $checkOutDate->diff($checkInDate)->days;

        // Tính giá phòng
        $roomPrice = $room['price'] * $days;

        // Tính giá dịch vụ
        $servicePrice = 0;
        if (!empty($services)) {
            foreach ($services as $serviceId) {
                $service = $this->serviceModel->getById($serviceId);
                if ($service) {
                    $servicePrice += $service['price'];
                }
            }
        }

        return $roomPrice + $servicePrice;
    }

    public function show($id) {
        $this->requireLogin();

        $booking = $this->bookingModel->getBookingDetails($id);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $this->redirect('/bookings');
        }

        $services = $this->serviceModel->getServiceOrders($id);
        
        $data = [
            'booking' => $booking,
            'services' => $services
        ];

        $this->render('bookings/show', $data);
    }

    public function addService($bookingId) {
        $this->requireLogin();

        $booking = $this->bookingModel->getById($bookingId);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $this->redirect('/bookings');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRequest(['service_id']);
            
            if (empty($errors)) {
                $serviceData = [
                    'service_id' => $_POST['service_id'],
                    'booking_id' => $bookingId
                ];

                if ($this->serviceModel->createServiceOrder($serviceData)) {
                    $this->redirect('/bookings/' . $bookingId . '?service_added=1');
                } else {
                    $errors['general'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }

            $services = $this->serviceModel->getActiveServices();
            $this->render('bookings/add-service', [
                'booking' => $booking,
                'services' => $services,
                'errors' => $errors
            ]);
        } else {
            $services = $this->serviceModel->getActiveServices();
            $this->render('bookings/add-service', [
                'booking' => $booking,
                'services' => $services
            ]);
        }
    }

    public function payment($id) {
        $this->requireLogin();

        $booking = $this->bookingModel->getById($id);
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $this->redirect('/bookings');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRequest(['payment_method']);
            
            if (empty($errors)) {
                // Xử lý thanh toán
                $paymentSuccess = $this->processPayment($booking, $_POST['payment_method']);
                
                if ($paymentSuccess) {
                    $this->bookingModel->updateBookingStatus($id, BOOKING_STATUS_CONFIRMED);
                    $this->redirect('/bookings?paid=1');
                } else {
                    $errors['general'] = 'Thanh toán thất bại, vui lòng thử lại';
                }
            }

            $this->render('bookings/payment', [
                'booking' => $booking,
                'errors' => $errors
            ]);
        } else {
            $this->render('bookings/payment', ['booking' => $booking]);
        }
    }

    private function processPayment($booking, $method) {
        // TODO: Implement payment processing
        // This is just a mock implementation
        return true;
    }
} 