<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?php echo isset($room) ? 'Chỉnh sửa phòng' : 'Thêm phòng mới'; ?></h1>
        <a href="<?php echo BASE_URL; ?>/admin/rooms" class="btn btn-secondary">
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
            <form action="<?php echo BASE_URL; ?>/admin/rooms?action=save" method="POST" enctype="multipart/form-data">
                <?php if (isset($room)): ?>
                    <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo isset($room) ? $room['name'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Loại phòng</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Chọn loại phòng</option>
                                <option value="standard" <?php echo (isset($room) && $room['type'] == 'standard') ? 'selected' : ''; ?>>Standard</option>
                                <option value="deluxe" <?php echo (isset($room) && $room['type'] == 'deluxe') ? 'selected' : ''; ?>>Deluxe</option>
                                <option value="suite" <?php echo (isset($room) && $room['type'] == 'suite') ? 'selected' : ''; ?>>Suite</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá phòng</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?php echo isset($room) ? $room['price'] : ''; ?>" required>
                                <span class="input-group-text">đ</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available" <?php echo (isset($room) && $room['status'] == 'available') ? 'selected' : ''; ?>>Còn trống</option>
                                <option value="booked" <?php echo (isset($room) && $room['status'] == 'booked') ? 'selected' : ''; ?>>Đã đặt</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($room) ? $room['description'] : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh phòng</label>
                            <?php if (isset($room) && $room['image']): ?>
                                <div class="mb-2">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $room['image']; ?>" 
                                         alt="<?php echo $room['name']; ?>" 
                                         class="img-thumbnail" 
                                         style="width: 200px; height: 120px; object-fit: cover;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Chỉ chấp nhận file ảnh (JPG, PNG, GIF)</small>
                        </div>

                        <div class="mb-3">
                            <label for="capacity" class="form-label">Sức chứa</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo isset($room) ? $room['capacity'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="amenities" class="form-label">Tiện ích</label>
                            <textarea class="form-control" id="amenities" name="amenities" rows="3"><?php echo isset($room) && isset($room['amenities']) ? $room['amenities'] : ''; ?></textarea>
                            <small class="text-muted">Mỗi tiện ích cách nhau bằng dấu phẩy</small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/admin/layouts/footer.php'; ?> 