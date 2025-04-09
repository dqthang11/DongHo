<?php require_once 'views/layouts/header.php'; ?>

<!-- Debug info -->
<div style="display: none">
    <?php
    echo "Debug: Số lượng phòng = " . (isset($rooms) ? count($rooms) : 'không có biến $rooms');
    echo "<br>";
    echo "Debug: Thông tin phòng = ";
    var_dump($rooms);
    ?>
</div>

<!-- Search Section -->
<section class="search-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Tìm phòng phù hợp</h3>
                        <form action="<?php echo BASE_URL; ?>?act=room-search" method="GET" class="row g-3">
                            <input type="hidden" name="act" value="room-search">
                            <div class="col-md-4">
                                <label class="form-label">Loại phòng</label>
                                <select class="form-select" name="type">
                                    <option value="">Tất cả</option>
                                    <?php if (isset($roomTypes) && is_array($roomTypes)): ?>
                                        <?php foreach ($roomTypes as $type): ?>
                                        <option value="<?php echo $type; ?>" <?php echo isset($_GET['type']) && $_GET['type'] == $type ? 'selected' : ''; ?>>
                                            <?php echo $type; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Khoảng giá</label>
                                <select class="form-select" name="price_range">
                                    <option value="">Tất cả</option>
                                    <option value="0-500000" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '0-500000' ? 'selected' : ''; ?>>Dưới 500.000đ</option>
                                    <option value="500000-1000000" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '500000-1000000' ? 'selected' : ''; ?>>500.000đ - 1.000.000đ</option>
                                    <option value="1000000-2000000" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '1000000-2000000' ? 'selected' : ''; ?>>1.000.000đ - 2.000.000đ</option>
                                    <option value="2000000-5000000" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '2000000-5000000' ? 'selected' : ''; ?>>2.000.000đ - 5.000.000đ</option>
                                    <option value="5000000-999999999" <?php echo isset($_GET['price_range']) && $_GET['price_range'] == '5000000-999999999' ? 'selected' : ''; ?>>Trên 5.000.000đ</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Rooms List -->
<section class="rooms-section py-5">
    <div class="container">
        <?php if (isset($rooms) && !empty($rooms)): ?>
            <div class="row g-4">
                <?php foreach ($rooms as $room): ?>
                <div class="col-md-4">
                    <div class="card h-100 room-card">
                        <div class="room-image-wrapper">
                            <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $room['image']; ?>" 
                                 class="card-img-top" alt="<?php echo $room['name']; ?>">
                            <div class="room-overlay">
                                <a href="<?php echo BASE_URL; ?>?act=room-detail&id=<?php echo $room['id']; ?>" 
                                   class="btn btn-light btn-view">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </a>
                            </div>
                            <div class="room-badges">
                                <span class="badge status-badge <?php echo $room['status'] === 'available' ? 'available' : 'booked'; ?>">
                                    <i class="fas <?php echo $room['status'] === 'available' ? 'fa-check-circle' : 'fa-clock'; ?> me-1"></i>
                                    <?php echo $room['status'] === 'available' ? 'Còn trống' : 'Đã đặt'; ?>
                                </span>
                                <span class="badge capacity-badge">
                                    <i class="fas fa-users me-1"></i>
                                    <?php echo isset($room['capacity']) ? $room['capacity'] : '2'; ?> người
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="room-type">
                                <span class="type-badge">
                                    <i class="fas fa-hotel me-1"></i>
                                    <?php echo $room['type'] ?? 'Standard'; ?>
                                </span>
                            </div>
                            <h5 class="room-title"><?php echo $room['name']; ?></h5>
                            <div class="room-amenities mb-3">
                                <span class="amenity-item"><i class="fas fa-wifi"></i></span>
                                <span class="amenity-item"><i class="fas fa-tv"></i></span>
                                <span class="amenity-item"><i class="fas fa-snowflake"></i></span>
                                <span class="amenity-item"><i class="fas fa-coffee"></i></span>
                            </div>
                            <p class="room-description"><?php echo substr($room['description'], 0, 100) . '...'; ?></p>
                            <div class="room-price">
                                <div class="price-tag">
                                    <span class="amount"><?php echo number_format($room['price'], 0, ',', '.'); ?>đ</span>
                                    <span class="period">/đêm</span>
                                </div>
                                <a href="<?php echo BASE_URL; ?>?act=booking&id=<?php echo $room['id']; ?>" 
                                   class="btn btn-book <?php echo $room['status'] === 'available' ? 'btn-primary' : 'btn-secondary disabled'; ?>">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    <?php echo $room['status'] === 'available' ? 'Đặt ngay' : 'Hết phòng'; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-hotel fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Không tìm thấy phòng phù hợp</h4>
                <p class="text-muted">Vui lòng thử lại với bộ lọc khác</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.rooms-section {
    background-color: #f8f9fa;
}

.room-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
}

.room-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

.room-image-wrapper {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.room-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.room-card:hover .room-image-wrapper img {
    transform: scale(1.1);
}

.room-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
}

.room-card:hover .room-overlay {
    opacity: 1;
}

.btn-view {
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 500;
    transform: translateY(20px);
    transition: all 0.4s ease;
}

.room-card:hover .btn-view {
    transform: translateY(0);
}

.room-badges {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.status-badge, .capacity-badge {
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.status-badge.available {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.status-badge.booked {
    background: linear-gradient(45deg, #dc3545, #fd7e14);
    color: white;
}

.capacity-badge {
    background: linear-gradient(45deg, #007bff, #6610f2);
    color: white;
}

.room-type {
    margin-bottom: 10px;
}

.type-badge {
    background: #e9ecef;
    color: #495057;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
}

.room-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #343a40;
}

.room-amenities {
    display: flex;
    gap: 15px;
}

.amenity-item {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    transition: all 0.3s ease;
}

.amenity-item:hover {
    background: #007bff;
    color: white;
    transform: translateY(-3px);
}

.room-description {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.room-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #dee2e6;
    padding-top: 15px;
}

.price-tag {
    display: flex;
    flex-direction: column;
}

.price-tag .amount {
    font-size: 1.5rem;
    font-weight: 600;
    color: #007bff;
}

.price-tag .period {
    font-size: 0.85rem;
    color: #6c757d;
}

.btn-book {
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-book:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

/* Animation on scroll */
.room-card {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.room-card.visible {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 768px) {
    .room-image-wrapper {
        height: 220px;
    }
    
    .room-title {
        font-size: 1.1rem;
    }
    
    .price-tag .amount {
        font-size: 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                setTimeout(() => {
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.room-card').forEach((card, index) => {
        observer.observe(card);
        card.style.transitionDelay = `${index * 100}ms`;
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 