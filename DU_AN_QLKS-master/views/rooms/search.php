<?php require_once 'views/layouts/header.php'; ?>

<!-- Search Results -->
<section class="search-results py-5">
    <div class="container">
        <h2 class="text-center mb-5">Kết quả tìm kiếm</h2>

        <!-- Search Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>?act=room-search" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Loại phòng</label>
                        <select class="form-select" name="type">
                            <option value="">Tất cả</option>
                            <?php foreach ($roomTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo isset($filters['type']) && $filters['type'] === $type ? 'selected' : ''; ?>>
                                <?php echo ucfirst($type); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Giá tối thiểu</label>
                        <input type="number" class="form-control" name="min_price" 
                               value="<?php echo $filters['min_price'] ?? ''; ?>" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Giá tối đa</label>
                        <input type="number" class="form-control" name="max_price" 
                               value="<?php echo $filters['max_price'] ?? ''; ?>" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        <?php if (isset($rooms) && !empty($rooms)): ?>
            <div class="row g-4">
                <?php foreach ($rooms as $room): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <?php
                            // Xác định ảnh dựa trên loại phòng
                            $roomImage = 'default.jpg';
                            switch($room['type']) {
                                case 'standard':
                                    $roomImage = 'standard-room.jpg';
                                    break;
                                case 'deluxe':
                                    $roomImage = 'deluxe-room.jpg';
                                    break;
                                case 'suite':
                                    $roomImage = 'suite-room.jpg';
                                    break;
                                case 'vip':
                                    $roomImage = 'vip-room.jpg';
                                    break;
                            }
                            ?>
                            <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo isset($room['image']) && $room['image'] ? $room['image'] : $roomImage; ?>" 
                                 class="card-img-top" alt="<?php echo $room['name']; ?>"
                                 onerror="this.src='<?php echo BASE_URL; ?>/assets/images/rooms/default.jpg'">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge <?php echo $room['status'] === 'available' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $room['status'] === 'available' ? 'Còn trống' : 'Đã đặt'; ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $room['name']; ?></h5>
                            <p class="card-text text-muted"><?php echo $room['description']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">
                                    <?php echo number_format($room['price'], 0, ',', '.'); ?>đ/đêm
                                </span>
                                <a href="<?php echo BASE_URL; ?>?act=room-detail&id=<?php echo $room['id']; ?>" 
                                   class="btn btn-outline-primary">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Không tìm thấy phòng nào phù hợp với tiêu chí tìm kiếm.
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.search-results .card-img-top {
    height: 250px;
    object-fit: cover;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
}

.card:hover .card-img-top {
    opacity: 0.9;
}
</style>

<?php require_once 'views/layouts/footer.php'; ?> 