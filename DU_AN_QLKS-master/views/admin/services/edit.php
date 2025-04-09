<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Chỉnh sửa dịch vụ</h1>
        <a href="<?php echo BASE_URL; ?>/admin/services" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

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
            <form action="<?php echo BASE_URL; ?>/admin/services?action=edit&id=<?php echo $service['id']; ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên dịch vụ</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo $service['name']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá dịch vụ</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?php echo $service['price']; ?>" required>
                                <span class="input-group-text">đ</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?php echo $service['status'] == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                                <option value="inactive" <?php echo $service['status'] == 'inactive' ? 'selected' : ''; ?>>Không hoạt động</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo $service['description']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL hình ảnh</label>
                            <?php if (!empty($service['image_url'])): ?>
                                <div class="mb-2">
                                    <img src="<?php echo $service['image_url']; ?>" 
                                         alt="<?php echo $service['name']; ?>" 
                                         class="img-thumbnail" 
                                         style="width: 200px; height: 120px; object-fit: cover;"
                                         onerror="this.src='<?php echo BASE_URL; ?>/assets/images/no-image.jpg'">
                                </div>
                            <?php endif; ?>
                            <input type="url" class="form-control" id="image_url" name="image_url" 
                                   value="<?php echo $service['image_url']; ?>" 
                                   placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Nhập URL hình ảnh từ internet</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/admin/layouts/footer.php'; ?> 