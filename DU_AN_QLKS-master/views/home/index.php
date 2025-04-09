<?php require_once 'views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero text-white py-5 position-relative overflow-hidden">
    <div class="hero-particles" id="particles-js"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in-left">
                <span class="badge bg-light text-primary mb-3 px-3 py-2">Khách sạn 5 sao</span>
                <h1 class="display-3 fw-bold mb-4">Chào mừng đến với<br>Hotel Management<br>System</h1>
                <p class="lead mb-4 opacity-90">
                    Trải nghiệm đẳng cấp 5 sao với dịch vụ hoàn hảo, phòng nghỉ tiện nghi và đội ngũ nhân viên chuyên nghiệp.
                </p>
                <div class="d-flex gap-3 mb-5">
                    <a href="#search" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-search me-2"></i>Tìm phòng
                    </a>
                    <a href="<?php echo BASE_URL; ?>?act=rooms" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-bed me-2"></i>Xem phòng
                    </a>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="hero-image-wrapper mb-5">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1470&auto=format&fit=crop" 
                         alt="Hotel Hero" 
                         class="img-fluid rounded-4 shadow-lg">
                    <div class="floating-card">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">Phòng cao cấp</h6>
                                <p class="mb-0 small">Tiện nghi hiện đại</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Form -->
        <div class="row mt-4" id="search">
            <div class="col-12">
                <div class="card search-card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <form action="<?php echo BASE_URL; ?>?act=search" method="GET" class="row g-4">
                            <input type="hidden" name="act" value="search">
                            <div class="col-md-3">
                                <label for="check_in" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Ngày nhận phòng
                                </label>
                                <input type="date" class="form-control form-control-lg" id="check_in" name="check_in" required 
                                       min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="check_out" class="form-label fw-bold">
                                    <i class="fas fa-calendar-check me-2 text-primary"></i>Ngày trả phòng
                                </label>
                                <input type="date" class="form-control form-control-lg" id="check_out" name="check_out" required 
                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="type" class="form-label fw-bold">
                                    <i class="fas fa-bed me-2 text-primary"></i>Loại phòng
                                </label>
                                <select class="form-select form-select-lg" id="type" name="type">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($roomTypes as $type): ?>
                                        <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="price_range" class="form-label fw-bold">
                                    <i class="fas fa-tag me-2 text-primary"></i>Khoảng giá
                                </label>
                                <select class="form-select form-select-lg" id="price_range" name="price_range">
                                    <option value="">Tất cả</option>
                                    <option value="0-500000">Dưới 500,000đ</option>
                                    <option value="500000-1000000">500,000đ - 1,000,000đ</option>
                                    <option value="1000000-2000000">1,000,000đ - 2,000,000đ</option>
                                    <option value="2000000-999999999">Trên 2,000,000đ</option>
                                </select>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="width: 100%; height: 120px;">
            <path fill="#ffffff" fill-opacity="1" d="M0,128L48,122.7C96,117,192,107,288,90.7C384,75,480,53,576,58.7C672,64,768,96,864,96C960,96,1056,64,1152,48C1248,32,1344,32,1392,32L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Featured Rooms -->
<section class="featured-rooms py-5 position-relative">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="badge bg-primary px-3 py-2 mb-3">Phòng nổi bật</span>
            <h2 class="display-4 fw-bold mb-3">Phòng nghỉ nổi bật</h2>
            <p class="lead text-muted">Khám phá những phòng nghỉ được yêu thích nhất của chúng tôi</p>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredRooms as $index => $room): ?>
            <div class="col-md-4 fade-in-up" style="animation-delay: <?php echo $index * 0.2; ?>s">
                <div class="card room-card h-100 border-0 shadow-sm">
                    <div class="room-img-wrapper">
                        <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $room['image']; ?>" 
                             class="card-img-top" alt="<?php echo $room['name']; ?>">
                        <div class="room-overlay">
                            <a href="<?php echo BASE_URL; ?>?act=room-detail&id=<?php echo $room['id']; ?>" 
                               class="btn btn-light btn-lg">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                        <div class="room-badges">
                            <span class="badge bg-primary rounded-pill">
                                <?php echo ucfirst($room['type']); ?>
                            </span>
                            <div class="rating-badge">
                                <i class="fas fa-star text-warning"></i>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="room-icon mb-3">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h5 class="card-title text-center mb-3 fw-bold"><?php echo $room['name']; ?></h5>
                        <p class="card-text text-muted text-center mb-3"><?php echo $room['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="price-badge">
                                    <?php echo number_format($room['price'], 0, ',', '.'); ?>đ
                                </span>
                                <small class="text-muted d-block mt-1">/đêm</small>
                            </div>
                            <a href="<?php echo BASE_URL; ?>?act=room-detail&id=<?php echo $room['id']; ?>" 
                               class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-info-circle me-2"></i>Chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="section-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" style="width: 100%; height: 120px;">
            <path fill="#f8f9fa" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Services -->
<section class="services py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Dịch vụ của chúng tôi</h2>
            <p class="lead text-muted">Trải nghiệm những dịch vụ đẳng cấp 5 sao</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="service-img-wrapper mb-4">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&auto=format&fit=crop" 
                                 class="service-img" 
                                 alt="Ăn sáng">
                            <div class="service-overlay">
                                <a href="#" class="btn btn-light btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                        <h4 class="card-title text-center mb-3 fw-bold">Ăn sáng</h4>
                        <p class="card-text text-muted text-center mb-3">Buffet sáng với nhiều món ngon đa dạng, phong phú</p>
                        <div class="text-center">
                            <span class="price-badge">200.000đ</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="service-img-wrapper mb-4">
                            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&auto=format&fit=crop" 
                                 class="service-img" 
                                 alt="Xe đưa đón sân bay">
                            <div class="service-overlay">
                                <a href="#" class="btn btn-light btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                        <h4 class="card-title text-center mb-3 fw-bold">Xe đưa đón sân bay</h4>
                        <p class="card-text text-muted text-center mb-3">Dịch vụ đưa đón sân bay chuyên nghiệp, tiện lợi</p>
                        <div class="text-center">
                            <span class="price-badge">500.000đ</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="service-img-wrapper mb-4">
                            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&auto=format&fit=crop" 
                                 class="service-img" 
                                 alt="Massage">
                            <div class="service-overlay">
                                <a href="#" class="btn btn-light btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                        <h4 class="card-title text-center mb-3 fw-bold">Massage</h4>
                        <p class="card-text text-muted text-center mb-3">Dịch vụ massage thư giãn chuyên nghiệp</p>
                        <div class="text-center">
                            <span class="price-badge">300.000đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Reviews -->
<section class="reviews py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Đánh giá gần đây</h2>
            <p class="lead text-muted">Những trải nghiệm thực tế từ khách hàng của chúng tôi</p>
        </div>
        <div class="row g-4">
            <?php foreach ($recentReviews as $review): ?>
            <div class="col-md-4">
                <div class="card review-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-wrapper me-3">
                                <img src="<?php echo BASE_URL; ?>/assets/images/avatar.png" 
                                     alt="User Avatar" 
                                     class="avatar-img rounded-circle">
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold"><?php echo $review['user_name']; ?></h5>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($review['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                        <div class="rating mb-3">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text review-text"><?php echo $review['comment']; ?></p>
                        <div class="mt-3">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-bed me-1"></i>
                                <?php echo $review['room_name']; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="stats bg-primary text-white py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="fas fa-bed fa-3x mb-3"></i>
                <h3 class="mb-0"><?php echo $stats['total_rooms']; ?></h3>
                <p class="mb-0">Tổng số phòng</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                <h3 class="mb-0"><?php echo $stats['total_bookings']; ?></h3>
                <p class="mb-0">Đặt phòng thành công</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="fas fa-concierge-bell fa-3x mb-3"></i>
                <h3 class="mb-0"><?php echo $stats['total_services']; ?></h3>
                <p class="mb-0">Dịch vụ đa dạng</p>
            </div>
            <div class="col-md-3">
                <i class="fas fa-star fa-3x mb-3"></i>
                <h3 class="mb-0"><?php echo $stats['total_reviews']; ?></h3>
                <p class="mb-0">Đánh giá từ khách hàng</p>
            </div>
        </div>
    </div>
</section>

<style>
.hero {
    background: linear-gradient(135deg, rgba(26, 79, 124, 0.95) 0%, rgba(45, 149, 227, 0.95) 100%), url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1470&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
    padding: 100px 0 180px;
    position: relative;
    overflow: hidden;
}

.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero .container {
    position: relative;
    z-index: 2;
}

.hero-wave {
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    z-index: 2;
    line-height: 0;
}

.hero-wave svg {
    filter: drop-shadow(0 -4px 4px rgba(0,0,0,0.1));
}

.hero-image-wrapper {
    position: relative;
    perspective: 1000px;
}

.hero-image-wrapper img {
    transform: rotateY(-15deg) translateZ(50px);
    transition: all 0.5s ease;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
}

.hero-image-wrapper:hover img {
    transform: rotateY(0) translateZ(0);
}

.floating-card {
    position: absolute;
    bottom: -20px;
    right: -20px;
    background: white;
    padding: 15px 25px;
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    animation: float 3s ease-in-out infinite;
}

.floating-card .icon-wrapper {
    width: 45px;
    height: 45px;
    background: #e3f2fd;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1976d2;
    font-size: 1.2rem;
}

.search-card {
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

.search-card .form-control,
.search-card .form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.search-card .form-control:focus,
.search-card .form-select:focus {
    border-color: #1976d2;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.1);
}

.search-card .btn-primary {
    border-radius: 12px;
    padding: 1rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.fade-in-left {
    animation: fadeInLeft 1s ease forwards;
}

.fade-in-right {
    animation: fadeInRight 1s ease forwards;
}

@keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0); }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@media (max-width: 991.98px) {
    .hero {
        padding: 80px 0 140px;
    }
    
    .hero h1 {
        font-size: 2.5rem;
    }
    
    .hero .col-lg-6:last-child {
        margin-top: 2rem;
    }
    
    .hero-image-wrapper {
        margin-bottom: 3rem !important;
    }
    
    .hero-wave svg {
        height: 80px;
    }
    
    .floating-card {
        display: none;
    }
}

@media (max-width: 768px) {
    .search-card .col-md-3 {
        margin-bottom: 1rem;
    }
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.social-links a {
    transition: opacity 0.3s ease;
}

.social-links a:hover {
    opacity: 0.8;
}

.stats i {
    opacity: 0.9;
}

.stats h3 {
    font-size: 2.5rem;
    font-weight: bold;
}

.stats p {
    font-size: 1.1rem;
    opacity: 0.9;
}

.services {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    position: relative;
    overflow: hidden;
}

.services::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100 M100,0 L0,100" stroke="%23f0f0f0" stroke-width="1"/></svg>');
    opacity: 0.1;
    z-index: 0;
}

.service-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    position: relative;
    z-index: 1;
    background: white;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.service-img-wrapper {
    height: 250px;
    overflow: hidden;
    border-radius: 12px;
    position: relative;
}

.service-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.service-card:hover .service-img {
    transform: scale(1.1);
}

.service-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.service-card:hover .service-overlay {
    opacity: 1;
}

.price-badge {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: bold;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(0,123,255,0.2);
}

.services h4 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
}

.services p {
    color: #6c757d;
    line-height: 1.6;
    font-size: 0.95rem;
}

@media (max-width: 768px) {
    .service-img-wrapper {
        height: 200px;
    }
    
    .services h2 {
        font-size: 2rem;
    }
}

.featured-rooms {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    position: relative;
    padding-bottom: 100px;
}

.room-card {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    border-radius: 20px;
    overflow: hidden;
    background: white;
}

.room-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.room-img-wrapper {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.room-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.room-card:hover .room-img-wrapper img {
    transform: scale(1.1);
}

.room-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.room-card:hover .room-overlay {
    opacity: 1;
}

.room-badges {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 1;
}

.rating-badge {
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.room-icon {
    width: 60px;
    height: 60px;
    background: #e3f2fd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: #1976d2;
    font-size: 1.5rem;
    margin-top: -50px;
    position: relative;
    z-index: 1;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.section-shape {
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    z-index: 1;
    line-height: 0;
}

.section-shape svg {
    filter: drop-shadow(0 -4px 4px rgba(0,0,0,0.1));
}

@media (max-width: 768px) {
    .room-img-wrapper {
        height: 200px;
    }
    
    .room-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        margin-top: -40px;
    }
}

.reviews {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.review-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    background: white;
    opacity: 1;
    transform: none;
}

.review-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}

.avatar-wrapper {
    width: 50px;
    height: 50px;
    overflow: hidden;
    border-radius: 50%;
    border: 2px solid #007bff;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rating {
    color: #ffc107;
    font-size: 1.1rem;
}

.review-text {
    color: #6c757d;
    line-height: 1.6;
    font-style: italic;
}

.review-card .badge {
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 500;
}

/* Remove scroll animation for review cards */
.review-card {
    opacity: 1 !important;
    transform: none !important;
}
</style>

<!-- Particles JS -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Particles JS Config
    particlesJS('particles-js', {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: '#ffffff' },
            shape: { type: 'circle' },
            opacity: { value: 0.5, random: false },
            size: { value: 3, random: true },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#ffffff',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: false,
                straight: false,
                out_mode: 'out',
                bounce: false
            }
        },
        interactivity: {
            detect_on: 'canvas',
            events: {
                onhover: { enable: true, mode: 'repulse' },
                onclick: { enable: true, mode: 'push' },
                resize: true
            }
        },
        retina_detect: true
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 