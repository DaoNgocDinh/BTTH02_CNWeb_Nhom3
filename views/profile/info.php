<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<div class="profile-wrapper">

    <div class="profile-header">

        <div>
            <div class="profile-name">
                <span>Tôi: </span>
                <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>
            </div>
            <div class="profile-role">
                <?php
                echo match ($user['role']) {
                    2 => 'Administrator',
                    1 => 'Teacher',
                    default => 'Student'
                };
                ?>
            </div>
        </div>
    </div>

    <div class="profile-info">

        <div class="profile-item">
            <div class="profile-label">Tên đăng nhập</div>
            <div class="profile-value"><?= htmlspecialchars($user['username']) ?></div>
        </div>

        <div class="profile-item">
            <div class="profile-label">Email</div>
            <div class="profile-value"><?= htmlspecialchars($user['email']) ?></div>
        </div>

        <div class="profile-item">
            <div class="profile-label">Họ và tên</div>
            <div class="profile-value"><?= htmlspecialchars($user['fullname'] ?? '') ?></div>
        </div>

        <div class="profile-item">
            <div class="profile-label">Vai trò</div>
            <div class="profile-value">
                <?php
                echo match ($user['role']) {
                    2 => 'Admin',
                    1 => 'Giảng viên',
                    default => 'Sinh viên'
                };
                ?>
            </div>
        </div>

    </div>

</div>
<style>
    /* ============================= */
/* PROFILE PAGE */
/* ============================= */

.profile-wrapper {
    max-width: 720px;
    margin: 40px auto;
    background: #111827;
    border-radius: 14px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    color: #e5e7eb;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid #374151;
    padding-bottom: 20px;
    margin-bottom: 25px;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #3b82f6;
}

.profile-name {
    font-size: 22px;
    font-weight: 600;
}

.profile-role {
    font-size: 14px;
    color: #9ca3af;
    margin-top: 4px;
}

.profile-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 24px;
}

.profile-item {
    background: #1f2933;
    padding: 14px 16px;
    border-radius: 10px;
}

.profile-label {
    font-size: 13px;
    color: #9ca3af;
    margin-bottom: 6px;
}

.profile-value {
    font-size: 15px;
    font-weight: 500;
    color: #f9fafb;
}

/* Responsive */
@media (max-width: 640px) {
    .profile-info {
        grid-template-columns: 1fr;
    }
}

</style>