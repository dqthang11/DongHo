<?php
// Check if user data is available
if (!isset($user)) {
    echo "User data not found";
    return;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>User Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?php echo isset($user['name']) ? htmlspecialchars($user['name']) : 'Not set'; ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 