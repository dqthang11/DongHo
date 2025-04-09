<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý dịch vụ</h1>
        <a href="<?php echo BASE_URL; ?>/admin/services/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm dịch vụ
        </a>
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
                            <th>Tên dịch vụ</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Hình ảnh</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td>#<?php echo $service['id']; ?></td>
                            <td><?php echo $service['name']; ?></td>
                            <td><?php echo $service['description']; ?></td>
                            <td><?php echo number_format($service['price'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <?php if (!empty($service['image_url'])): ?>
                                    <img src="<?php echo $service['image_url']; ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo $service['name']; ?>"
                                         style="height: 50px; width: 50px; object-fit: cover;"
                                         onerror="this.src='<?php echo BASE_URL; ?>/assets/images/no-image.jpg'">
                                <?php else: ?>
                                    <img src="<?php echo BASE_URL; ?>/assets/images/no-image.jpg" 
                                         alt="No image" 
                                         class="img-fluid rounded"
                                         style="height: 50px; width: 50px; object-fit: cover;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo (!empty($service['status']) && $service['status'] == 'active') ? 'success' : 'danger'; ?>">
                                    <?php echo (!empty($service['status']) && $service['status'] == 'active') ? 'Hoạt động' : 'Không hoạt động'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/admin/services?action=edit&id=<?php echo $service['id']; ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/admin/services?action=delete&id=<?php echo $service['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')">
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