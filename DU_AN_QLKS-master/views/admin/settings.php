<?php require_once 'views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Cài đặt hệ thống</h1>
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
            <form action="<?php echo BASE_URL; ?>/admin/settings" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Thông tin website</h5>
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Tên website</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" 
                                   value="<?php echo SITE_NAME; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="site_description" class="form-label">Mô tả website</label>
                            <textarea class="form-control" id="site_description" name="site_description" 
                                      rows="3"><?php echo SITE_DESCRIPTION ?? ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3">Thông tin liên hệ</h5>
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Email liên hệ</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                   value="<?php echo CONTACT_EMAIL ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                   value="<?php echo CONTACT_PHONE ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" 
                                      rows="3"><?php echo ADDRESS ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="mb-3">Cài đặt email</h5>
                        <div class="mb-3">
                            <label for="smtp_host" class="form-label">SMTP Host</label>
                            <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                   value="<?php echo SMTP_HOST; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="smtp_port" class="form-label">SMTP Port</label>
                            <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                                   value="<?php echo SMTP_PORT; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="smtp_username" class="form-label">SMTP Username</label>
                            <input type="text" class="form-control" id="smtp_username" name="smtp_username" 
                                   value="<?php echo SMTP_USERNAME; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="smtp_password" class="form-label">SMTP Password</label>
                            <input type="password" class="form-control" id="smtp_password" name="smtp_password" 
                                   value="<?php echo SMTP_PASSWORD; ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3">Cài đặt khác</h5>
                        <div class="mb-3">
                            <label for="upload_path" class="form-label">Đường dẫn upload</label>
                            <input type="text" class="form-control" id="upload_path" name="upload_path" 
                                   value="<?php echo UPLOAD_PATH; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_file_size" class="form-label">Kích thước file tối đa (MB)</label>
                            <input type="number" class="form-control" id="max_file_size" name="max_file_size" 
                                   value="<?php echo MAX_FILE_SIZE / (1024 * 1024); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="session_lifetime" class="form-label">Thời gian phiên đăng nhập (phút)</label>
                            <input type="number" class="form-control" id="session_lifetime" name="session_lifetime" 
                                   value="<?php echo SESSION_LIFETIME / 60; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'views/admin/layouts/footer.php'; ?> 