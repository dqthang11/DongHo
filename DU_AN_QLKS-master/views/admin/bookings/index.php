<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý đặt phòng</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Phòng</th>
                            <th>Ngày nhận</th>
                            <th>Ngày trả</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['user_name']; ?></td>
                            <td><?php echo $booking['room_name']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($booking['check_in'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($booking['check_out'])); ?></td>
                            <td><?php echo number_format($booking['total_amount'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $booking['status'] == 'confirmed' ? 'success' : 
                                        ($booking['status'] == 'pending' ? 'warning' : 
                                        ($booking['status'] == 'cancelled' ? 'danger' : 'info')); 
                                ?>">
                                    <?php echo $booking['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/admin/bookings?action=view&id=<?php echo $booking['id']; ?>" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($booking['status'] == 'pending'): ?>
                                <a href="<?php echo BASE_URL; ?>/admin/bookings?action=confirm&id=<?php echo $booking['id']; ?>" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/admin/bookings?action=cancel&id=<?php echo $booking['id']; ?>" 
                                   class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/admin/layouts/footer.php'; ?> 