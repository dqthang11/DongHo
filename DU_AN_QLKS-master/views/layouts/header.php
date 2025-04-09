<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
        }

        .nav-link.active {
            color: white !important;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .alert {
            border-radius: 0;
            margin-bottom: 0;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-hotel me-2"></i>
                <?php echo SITE_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $action === 'home' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/home">
                            <i class="fas fa-home me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $action === 'rooms' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/rooms">
                            <i class="fas fa-bed me-1"></i> Phòng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $action === 'services' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/services">
                            <i class="fas fa-concierge-bell me-1"></i> Dịch vụ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $action === 'about' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/about">
                            <i class="fas fa-info-circle me-1"></i> Giới thiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $action === 'contact' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/contact">
                            <i class="fas fa-envelope me-1"></i> Liên hệ
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-link nav-link dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=admin-dashboard">
                                        <i class="fas fa-tachometer-alt me-2"></i>Quản trị
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=profile">
                                    <i class="fas fa-user-circle me-2"></i>Tài khoản
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=bookings">
                                    <i class="fas fa-calendar-alt me-2"></i>Đặt phòng
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=register">
                                    <i class="fas fa-user-plus me-2"></i>Đăng ký
                                </a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 