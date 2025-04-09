<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý đánh giá</h1>
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
                            <th>Người dùng</th>
                            <th>Phòng</th>
                            <th>Đánh giá</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?php echo $review['id']; ?></td>
                            <td><?php echo $review['user_name']; ?></td>
                            <td><?php echo $review['room_name']; ?></td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                <?php endfor; ?>
                            </td>
                            <td><?php echo substr($review['comment'], 0, 50) . '...'; ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo isset($review['status']) ? ($review['status'] == 'approved' ? 'success' : 
                                        ($review['status'] == 'pending' ? 'warning' : 'danger')) : 'warning'; 
                                ?>">
                                    <?php echo isset($review['status']) ? $review['status'] : 'pending'; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></td>
                            <td>
                                <?php if (!isset($review['status']) || $review['status'] == 'pending'): ?>
                                <a href="<?php echo BASE_URL; ?>/admin/reviews?action=approve&id=<?php echo $review['id']; ?>" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/admin/reviews?action=reject&id=<?php echo $review['id']; ?>" 
                                   class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo BASE_URL; ?>/admin/reviews?action=delete&id=<?php echo $review['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                    <i class="fas fa-trash"></i>
                                </a>
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