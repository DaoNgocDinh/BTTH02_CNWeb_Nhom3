<nav class="navbar">
    <div class="navbar-container">

        <a href="<?= BASE_URL ?>/" class="navbar-logo">
            2TĐ
        </a>

        <div class="navbar-right">

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 2): ?>
                <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-link">
                    📊 <span>Trang chủ</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/users" class="nav-link">
                    👥 <span>Quản lý người dùng</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/categories" class="nav-link">
                    📂 <span>Quản lý khóa học</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/statistics" class="nav-link">
                    📈 <span>Thống kê</span>
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/dashboard" class="nav-link">
                    🏠 <span>Trang chủ</span>
                </a>
                <a href="<?= BASE_URL ?>/courses" class="nav-link">
                    📚 <span>Khóa học</span>
                </a>
                <a href="<?= BASE_URL ?>/my-courses" class="nav-link">
                    ✅ <span>Khóa học của tôi</span>
                </a>
            <?php endif; ?>

            <span class="nav-separator">|</span>

            <div class="user-menu-wrapper">
                <div class="user-info-toggle">
                    <img src="<?= htmlspecialchars($_SESSION['user']['avatar_url'] ?? 'default_avatar.png') ?>" alt="Avatar" class="user-avatar">
                    <span class="user-name"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Tôi') ?></span>
                </div>
                
                <div class="user-dropdown-content">
                    <div class="user-details-summary">
                         <p class="font-semibold"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?></p>
                        <p class="text-xs text-gray-400"><?= $_SESSION['user']['role'] == 2 ? 'Administrator' : ($_SESSION['user']['role'] == 1 ? 'Teacher' : 'Student') ?></p>
                        <hr class="dropdown-hr">
                    </div>

                    <a href="<?= BASE_URL ?>/profile/change-avatar" class="dropdown-item">
                        <span class="dropdown-icon">🖼️</span> Thay đổi ảnh đại diện
                    </a>
                    <a href="<?= BASE_URL ?>/profile/info" class="dropdown-item">
                        <span class="dropdown-icon">⚙️</span> Thông tin cá nhân
                    </a>
                    <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout-link">
                        <span class="dropdown-icon">🚪</span> Đăng xuất
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</nav>