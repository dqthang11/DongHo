<?php require_once 'views/layouts/header.php'; ?>

<!-- Room Detail -->
<section class="room-detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div id="roomCarousel" class="carousel slide shadow-lg rounded-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $room['image']; ?>" 
                                 class="d-block w-100" alt="<?php echo $room['name']; ?>"
                                 style="height: 500px; object-fit: cover;">
                        </div>
                        <?php if (isset($room['images']) && is_array($room['images'])): ?>
                            <?php foreach ($room['images'] as $image): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $image; ?>" 
                                         class="d-block w-100" alt="<?php echo $room['name']; ?>"
                                         style="height: 500px; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <!-- Room Details -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h2 class="card-title fw-bold mb-4"><?php echo $room['name']; ?></h2>
                        
                        <!-- Room Features -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bed fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Loại giường</h6>
                                        <small class="text-muted"><?php echo $room['bed_type'] ?? 'Giường đôi'; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Sức chứa</h6>
                                        <small class="text-muted"><?php echo $room['capacity'] ?? '2'; ?> người</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-ruler-combined fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Diện tích</h6>
                                        <small class="text-muted"><?php echo $room['size'] ?? '30'; ?>m²</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wifi fa-2x text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Wifi</h6>
                                        <small class="text-muted">Miễn phí</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Room Description -->
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Mô tả phòng</h4>
                            <p class="text-muted"><?php echo $room['description']; ?></p>
                        </div>

                        <!-- Amenities -->
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Tiện ích</h4>
                            <div class="row g-3">
                                <?php 
                                $amenities = json_decode($room['amenities'] ?? '[]', true);
                                $amenityIcons = [
                                    'wifi' => 'fa-wifi',
                                    'tv' => 'fa-tv',
                                    'ac' => 'fa-snowflake',
                                    'minibar' => 'fa-glass-martini-alt',
                                    'safe' => 'fa-lock',
                                    'shower' => 'fa-shower',
                                    'breakfast' => 'fa-utensils',
                                    'pool' => 'fa-swimming-pool'
                                ];
                                foreach ($amenities as $amenity): ?>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas <?php echo $amenityIcons[$amenity] ?? 'fa-check'; ?> text-primary me-2"></i>
                                            <span><?php echo ucfirst($amenity); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Reviews -->
                        <?php if (!empty($reviews)): ?>
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Đánh giá</h4>
                            <div class="row g-4">
                                <?php foreach ($reviews as $review): ?>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($review['user_name']); ?>" 
                                                         class="rounded-circle" width="50" height="50">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0"><?php echo $review['user_name']; ?></h6>
                                                    <div class="text-warning">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <i class="fas fa-star<?php echo $i <= $review['rating'] ? '' : '-o'; ?>"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="card-text text-muted"><?php echo $review['comment']; ?></p>
                                            <small class="text-muted">
                                                <?php echo date('d/m/Y', strtotime($review['created_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="col-lg-4">
                <div class="card shadow-lg sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-4">Đặt phòng</h3>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="h4 mb-0 text-primary fw-bold">
                                    <?php echo number_format($room['price'], 0, ',', '.'); ?>đ
                                </span>
                                <small class="text-muted d-block">/đêm</small>
                            </div>
                            <span class="badge <?php echo $room['status'] === 'available' ? 'bg-success' : 'bg-danger'; ?> p-2">
                                <?php echo $room['status'] === 'available' ? 'Còn trống' : 'Đã đặt'; ?>
                            </span>
                        </div>

                        <form action="<?php echo BASE_URL; ?>?act=booking-create" method="POST">
                            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Ngày nhận phòng</label>
                                <input type="date" class="form-control" name="check_in" required 
                                       min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ngày trả phòng</label>
                                <input type="date" class="form-control" name="check_out" required 
                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số người</label>
                                <input type="number" class="form-control" name="guests" 
                                       min="1" max="<?php echo $room['capacity'] ?? '2'; ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Dịch vụ thêm</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="breakfast" id="breakfast">
                                    <label class="form-check-label" for="breakfast">
                                        Bữa sáng (150,000đ/người)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="spa" id="spa">
                                    <label class="form-check-label" for="spa">
                                        Spa (500,000đ/người)
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100" 
                                    <?php echo $room['status'] !== 'available' ? 'disabled' : ''; ?>>
                                <i class="fas fa-calendar-check me-2"></i>
                                <?php echo $room['status'] === 'available' ? 'Đặt phòng ngay' : 'Phòng đã được đặt'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Rooms -->
<section class="related-rooms bg-light py-5">
    <div class="container">
        <h3 class="text-center fw-bold mb-5">Phòng tương tự</h3>
        <div class="row g-4">
            <?php foreach ($similarRooms as $relatedRoom): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm room-card">
                    <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $relatedRoom['image']; ?>" 
                         class="card-img-top" alt="<?php echo $relatedRoom['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo $relatedRoom['name']; ?></h5>
                        <p class="card-text text-muted"><?php echo $relatedRoom['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="h5 mb-0 text-primary fw-bold">
                                    <?php echo number_format($relatedRoom['price'], 0, ',', '.'); ?>đ
                                </span>
                                <small class="text-muted d-block">/đêm</small>
                            </div>
                            <a href="<?php echo BASE_URL; ?>?act=room-detail&id=<?php echo $relatedRoom['id']; ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0,0,0,0.5);
    border-radius: 50%;
    padding: 20px;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}

.card {
    border: none;
    border-radius: 15px;
}

.badge {
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.btn-primary {
    border-radius: 20px;
    padding: 0.75rem 1.5rem;
}

.form-control {
    border-radius: 10px;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}

.sticky-top {
    z-index: 1020;
}

.room-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.room-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.room-card .card-img-top {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.room-card:hover .card-img-top {
    transform: scale(1.05);
}

.room-card .btn-primary {
    border-radius: 20px;
    padding: 0.5rem 1.5rem;
}

/* Animation on scroll */
.room-card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.room-card.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date inputs
    const checkInInput = document.querySelector('input[name="check_in"]');
    const checkOutInput = document.querySelector('input[name="check_out"]');

    checkInInput.addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        const nextDay = new Date(checkInDate);
        nextDay.setDate(nextDay.getDate() + 1);
        
        checkOutInput.min = nextDay.toISOString().split('T')[0];
        if (new Date(checkOutInput.value) < nextDay) {
            checkOutInput.value = nextDay.toISOString().split('T')[0];
        }
    });

    // Initialize carousel
    const roomCarousel = new bootstrap.Carousel(document.getElementById('roomCarousel'), {
        interval: 5000,
        pause: 'hover'
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.room-card').forEach(card => {
        observer.observe(card);
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 