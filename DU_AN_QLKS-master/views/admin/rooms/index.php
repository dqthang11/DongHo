<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Quản lý phòng</h1>
        <div>
            <a href="<?php echo BASE_URL; ?>/admin/rooms?action=create" class="btn btn-primary me-2">
                <i class="fas fa-plus me-2"></i>Thêm phòng mới
            </a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-2"></i>Nhập từ Excel
            </button>
        </div>
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

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Loại phòng</label>
                    <select class="form-select" name="type">
                        <option value="">Tất cả</option>
                        <?php foreach ($roomTypes as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo isset($_GET['type']) && $_GET['type'] == $type ? 'selected' : ''; ?>>
                                <?php echo $type; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-select" name="status">
                        <option value="">Tất cả</option>
                        <option value="available" <?php echo isset($_GET['status']) && $_GET['status'] == 'available' ? 'selected' : ''; ?>>Còn trống</option>
                        <option value="booked" <?php echo isset($_GET['status']) && $_GET['status'] == 'booked' ? 'selected' : ''; ?>>Đã đặt</option>
                        <option value="maintenance" <?php echo isset($_GET['status']) && $_GET['status'] == 'maintenance' ? 'selected' : ''; ?>>Bảo trì</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giá từ</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="min_price" placeholder="Tối thiểu" 
                               value="<?php echo $_GET['min_price'] ?? ''; ?>">
                        <span class="input-group-text">đ</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giá đến</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="max_price" placeholder="Tối đa" 
                               value="<?php echo $_GET['max_price'] ?? ''; ?>">
                        <span class="input-group-text">đ</span>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
                    <a href="<?php echo BASE_URL; ?>/admin/rooms" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Đặt lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Room Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Tổng số phòng</h6>
                            <h2 class="mb-0"><?php echo $totalRooms; ?></h2>
                        </div>
                        <i class="fas fa-hotel fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Phòng còn trống</h6>
                            <h2 class="mb-0"><?php echo $availableRooms; ?></h2>
                        </div>
                        <i class="fas fa-door-open fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Phòng đã đặt</h6>
                            <h2 class="mb-0"><?php echo $bookedRooms; ?></h2>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Phòng bảo trì</h6>
                            <h2 class="mb-0"><?php echo $maintenanceRooms; ?></h2>
                        </div>
                        <i class="fas fa-tools fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên phòng</th>
                            <th>Loại phòng</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?php echo $room['id']; ?></td>
                            <td>
                                <img src="<?php echo BASE_URL; ?>/assets/images/rooms/<?php echo $room['image']; ?>" 
                                     alt="<?php echo $room['name']; ?>" 
                                     class="img-thumbnail" 
                                     style="width: 100px; height: 60px; object-fit: cover;">
                            </td>
                            <td><?php echo $room['name']; ?></td>
                            <td><?php echo $room['type']; ?></td>
                            <td><?php echo number_format($room['price'], 0, ',', '.'); ?>đ</td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $room['status'] == 'available' ? 'success' : 
                                        ($room['status'] == 'booked' ? 'warning' : 'danger'); 
                                ?>">
                                    <?php 
                                    echo $room['status'] == 'available' ? 'Còn trống' : 
                                        ($room['status'] == 'booked' ? 'Đã đặt' : 'Bảo trì'); 
                                    ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo BASE_URL; ?>/admin/rooms?action=edit&id=<?php echo $room['id']; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="updateStatus(<?php echo $room['id']; ?>, '<?php echo $room['status']; ?>')">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/admin/rooms?action=delete&id=<?php echo $room['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nhập phòng từ Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL; ?>/admin/rooms?action=import" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Chọn file Excel</label>
                        <input type="file" class="form-control" name="excel_file" accept=".xlsx,.xls" required>
                        <small class="text-muted">Chỉ chấp nhận file Excel (.xlsx, .xls)</small>
                    </div>
                    <div class="mb-3">
                        <a href="<?php echo BASE_URL; ?>/assets/templates/rooms_template.xlsx" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Tải mẫu Excel
                        </a>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Tải lên
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.btn-group .btn {
    border-radius: 20px;
    margin: 0 2px;
}

.form-select, .form-control {
    border-radius: 10px;
}

.modal-content {
    border-radius: 15px;
    border: none;
}
</style>

<script>
function updateStatus(roomId, currentStatus) {
    const newStatus = currentStatus === 'available' ? 'booked' : 
                     currentStatus === 'booked' ? 'maintenance' : 'available';
    
    if (confirm(`Bạn có chắc chắn muốn chuyển trạng thái phòng sang "${newStatus}"?`)) {
        window.location.href = `<?php echo BASE_URL; ?>/admin/rooms?action=update-status&id=${roomId}&status=${newStatus}`;
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php require_once 'views/admin/layouts/footer.php'; ?> 