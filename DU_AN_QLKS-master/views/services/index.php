<?php require_once 'views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero bg-primary text-white py-5 position-relative overflow-hidden">
    <div class="hero-particles" id="particles-js"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in-left">
                <span class="badge bg-light text-primary mb-3 px-3 py-2">Dịch vụ cao cấp</span>
                <h1 class="display-4 fw-bold mb-4">Dịch vụ của chúng tôi</h1>
                <p class="lead mb-4 opacity-90">
                    Trải nghiệm dịch vụ đẳng cấp 5 sao với đội ngũ nhân viên chuyên nghiệp, 
                    tận tâm phục vụ 24/7.
                </p>
                <div class="d-flex gap-3 mb-5">
                    <a href="#services" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-arrow-down me-2"></i>Xem dịch vụ
                    </a>
                    <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-phone me-2"></i>Liên hệ ngay
                    </a>
                </div>
            </div>
            <div class="col-lg-6 fade-in-right">
                <div class="hero-image-wrapper mb-5">
                    <img src="<?php echo BASE_URL; ?>/assets/images/hero/services-hero.jpg" 
                         alt="Services Hero" 
                         class="img-fluid rounded-4 shadow-lg">
                    <div class="floating-card">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">Dịch vụ 24/7</h6>
                                <p class="mb-0 small">Phục vụ mọi lúc mọi nơi</p>
                            </div>
                        </div>
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

<!-- Services List -->
<section id="services" class="services-list py-5 bg-light position-relative">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="badge bg-primary px-3 py-2 mb-3">Dịch vụ của chúng tôi</span>
            <h2 class="display-5 fw-bold mb-3">Trải nghiệm dịch vụ cao cấp</h2>
            <p class="lead text-muted">Khám phá các dịch vụ đẳng cấp 5 sao của chúng tôi</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $index => $service): ?>
            <div class="col-md-4 fade-in-up" style="animation-delay: <?php echo $index * 0.2; ?>s">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="service-img-wrapper mb-4">
                            <?php if (!empty($service['image_url'])): ?>
                            <img src="<?php echo $service['image_url']; ?>" 
                                 class="img-fluid rounded-4" 
                                 alt="<?php echo $service['name']; ?>"
                                 style="height: 250px; width: 100%; object-fit: cover;"
                                 loading="lazy"
                                 onerror="this.src='<?php echo BASE_URL; ?>/assets/images/no-image.jpg'">
                            <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>/assets/images/no-image.jpg" 
                                 alt="No image" 
                                 class="img-fluid rounded-4"
                                 style="height: 250px; width: 100%; object-fit: cover;">
                            <?php endif; ?>
                            <div class="service-overlay rounded-4">
                                <button class="btn btn-light btn-lg" data-bs-toggle="modal" 
                                        data-bs-target="#serviceModal<?php echo $service['id']; ?>">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </button>
                            </div>
                        </div>
                        <div class="service-icon mb-3">
                            <i class="fas fa-<?php echo getServiceIcon($service['name']); ?>"></i>
                        </div>
                        <h5 class="card-title text-center mb-3"><?php echo $service['name']; ?></h5>
                        <p class="card-text text-muted text-center mb-3"><?php echo $service['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-badge">
                                <?php echo number_format($service['price'], 0, ',', '.'); ?>đ
                            </span>
                            <button class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" 
                                    data-bs-target="#serviceModal<?php echo $service['id']; ?>">
                                <i class="fas fa-info-circle me-2"></i>Chi tiết
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="services-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,192C384,181,480,139,576,138.7C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Service Modals -->
<?php foreach ($services as $service): ?>
<div class="modal fade" id="serviceModal<?php echo $service['id']; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="fas fa-<?php echo getServiceIcon($service['name']); ?> me-2"></i><?php echo $service['name']; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="service-modal-img mb-4">
                            <?php if (!empty($service['image_url'])): ?>
                            <img src="<?php echo $service['image_url']; ?>" 
                                 class="img-fluid rounded-4" 
                                 alt="<?php echo $service['name']; ?>"
                                 style="height: 300px; width: 100%; object-fit: cover;"
                                 onerror="this.src='<?php echo BASE_URL; ?>/assets/images/no-image.jpg'">
                            <?php else: ?>
                            <img src="<?php echo BASE_URL; ?>/assets/images/no-image.jpg" 
                                 alt="No image" 
                                 class="img-fluid rounded-4"
                                 style="height: 300px; width: 100%; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                        <p class="text-muted"><?php echo $service['description']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <div class="service-features p-4 bg-light rounded-4">
                            <h6 class="fw-bold mb-3">Chi tiết dịch vụ:</h6>
                            <ul class="list-unstyled service-features-list">
                                <?php if(isset($service['details']) && !empty($service['details'])): ?>
                                    <?php foreach (explode("\n", $service['details']) as $detail): ?>
                                    <li class="mb-3 d-flex align-items-center">
                                        <span class="feature-icon me-3">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </span>
                                        <span><?php echo $detail; ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="mb-3 d-flex align-items-center">
                                        <span class="feature-icon me-3">
                                            <i class="fas fa-info-circle text-primary"></i>
                                        </span>
                                        <span class="text-muted">Chưa có thông tin chi tiết</span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="service-price mt-4 p-3 bg-white rounded-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Giá dịch vụ</span>
                                    <h5 class="text-primary mb-0 fw-bold">
                                        <?php echo number_format($service['price'], 0, ',', '.'); ?>đ
                                    </h5>
                                </div>
                                <a href="<?php echo BASE_URL; ?>/contact" class="btn btn-primary btn-lg w-100 rounded-pill">
                                    <i class="fas fa-envelope me-2"></i>Liên hệ đặt dịch vụ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<style>
.hero {
    background: linear-gradient(135deg, #1a4f7c 0%, #2d95e3 100%);
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

.services-list {
    margin-top: -40px;
    padding-bottom: 100px;
}

.service-card {
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    border-radius: 20px;
    overflow: hidden;
    background: white;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.service-img-wrapper {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
}

.service-overlay {
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

.service-card:hover .service-overlay {
    opacity: 1;
}

.service-icon {
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

.price-badge {
    background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
    color: white;
    padding: 8px 20px;
    border-radius: 30px;
    font-weight: bold;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(25,118,210,0.2);
}

.service-features {
    border: 1px solid rgba(0,0,0,0.1);
}

.feature-icon {
    width: 32px;
    height: 32px;
    background: #e3f2fd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-price {
    border: 1px solid rgba(0,0,0,0.1);
}

.fade-in-left {
    animation: fadeInLeft 1s ease forwards;
}

.fade-in-right {
    animation: fadeInRight 1s ease forwards;
}

.fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
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

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
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
}

@media (max-width: 768px) {
    .service-img-wrapper {
        height: 200px;
    }
    
    .service-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        margin-top: -40px;
    }
}
</style>

<?php
function getServiceIcon($serviceName) {
    $icons = [
        'Ăn sáng' => 'utensils',
        'Xe đưa đón sân bay' => 'car',
        'Massage' => 'spa',
        'Giặt ủi' => 'tshirt',
        'Dọn phòng' => 'broom',
        'Fitness' => 'dumbbell',
        'Hồ bơi' => 'swimming-pool',
        'Bar' => 'glass-martini-alt',
        'default' => 'concierge-bell'
    ];
    
    $serviceName = mb_strtolower($serviceName, 'UTF-8');
    foreach ($icons as $key => $icon) {
        if (mb_strpos($serviceName, mb_strtolower($key, 'UTF-8')) !== false) {
            return $icon;
        }
    }
    return $icons['default'];
}
?>

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