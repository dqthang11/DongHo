<?php require_once 'views/layouts/header.php'; ?>

<!-- Bookings List -->
<section class="bookings-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">Đặt phòng của tôi</h2>

        <?php if (isset($bookings) && !empty($bookings)): ?>
            <div class="row g-4">
                <?php foreach ($bookings as $booking): ?>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0"><?php echo $booking['room_name']; ?></h5>
                                <span class="badge <?php 
                                    echo $booking['status'] === 'pending' ? 'bg-warning' : 
                                        ($booking['status'] === 'confirmed' ? 'bg-success' : 
                                        ($booking['status'] === 'cancelled' ? 'bg-danger' : 'bg-secondary')); 
                                ?>">
                                    <?php 
                                    echo $booking['status'] === 'pending' ? 'Chờ xác nhận' : 
                                        ($booking['status'] === 'confirmed' ? 'Đã xác nhận' : 
                                        ($booking['status'] === 'cancelled' ? 'Đã hủy' : 'Hoàn thành')); 
                                    ?>
                                </span>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Ngày nhận phòng:</strong></p>
                                    <p class="text-muted"><?php echo date('d/m/Y', strtotime($booking['check_in'])); ?></p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Ngày trả phòng:</strong></p>
                                    <p class="text-muted"><?php echo date('d/m/Y', strtotime($booking['check_out'])); ?></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Số người:</strong></p>
                                    <p class="text-muted"><?php echo $booking['guests']; ?> người</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Tổng tiền:</strong></p>
                                    <p class="text-primary h5 mb-0"><?php echo number_format($booking['total_price'], 0, ',', '.'); ?>đ</p>
                                </div>
                            </div>

                            <?php if ($booking['status'] === 'pending'): ?>
                            <div class="d-grid gap-2">
                                <a href="<?php echo BASE_URL; ?>?act=booking-cancel&id=<?php echo $booking['id']; ?>" 
                                   class="btn btn-outline-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn hủy đặt phòng này?')">
                                    <i class="fas fa-times me-2"></i>Hủy đặt phòng
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Bạn chưa có đặt phòng nào.
                <a href="<?php echo BASE_URL; ?>?act=rooms" class="alert-link">Đặt phòng ngay</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.bookings-section .card {
    transition: transform 0.3s ease;
}

.bookings-section .card:hover {
    transform: translateY(-5px);
}
</style>

<?php require_once 'views/layouts/footer.php'; ?> 