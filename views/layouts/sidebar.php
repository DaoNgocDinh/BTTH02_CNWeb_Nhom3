<nav class="navbar">
    <div class="navbar-container">

        <a href="<?= BASE_URL ?>/" class="navbar-logo">
            2TĐ
        </a>

        <div class="navbar-right">

            <?php
            $user = $_SESSION['user'] ?? null;
            $role = $user['role'] ?? null;
            ?>

            <?php if (!$user): ?>

                <a href="<?= BASE_URL ?>/" class="nav-link">
                    🏠 <span>Trang chủ</span>
                </a>

                <a href="<?= BASE_URL ?>/courses" class="nav-link">
                    📚 <span>Khóa học</span>
                </a>

                <span class="nav-separator">|</span>

                <a href="<?= BASE_URL ?>/login" class="nav-link login-link">
                    🔑 <span>Đăng nhập</span>
                </a>

                <a href="<?= BASE_URL ?>/register" class="nav-link register-link">
                    ✍️ <span>Đăng ký</span>
                </a>


                <?php elseif ($role == 2): ?>

                <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-link">
                    📊 <span>Trang chủ</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/users" class="nav-link">
                    👥 <span>Quản lý người dùng</span>
                </a>

                <a href="<?= BASE_URL ?>/instructor/course/manage" class="nav-link">
                    📚 <span>Quản lý khóa học</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/categories" class="nav-link">
                    📂 <span>Quản lý thể loại</span>
                </a>

                <a href="<?= BASE_URL ?>/admin/statistics" class="nav-link">
                    📈 <span>Thống kê</span>
                </a>

                <div class="user-menu-wrapper">

                    <div class="user-info-toggle">
                        <img src="<?= htmlspecialchars($user['avatar_url'] ?? 'default_avatar.png') ?>"
                            class="user-avatar">

                        <span class="user-name">
                            <?= htmlspecialchars($user['username']) ?>
                        </span>
                    </div>

                    <div class="user-dropdown-content">
                        <div class="user-details-summary">
                            <p class="font-semibold">
                                <?= htmlspecialchars($user['username']) ?>
                            </p>

                            <p class="text-xs text-gray-400">Administrator</p>

                            <hr class="dropdown-hr">
                        </div>
                        
                        <a href="<?= BASE_URL ?>/profile/change-avatar" class="dropdown-item">
                            🖼️ Thay đổi ảnh đại diện
                        </a>

                        <a href="<?= BASE_URL ?>/profile/info" class="dropdown-item">
                            ⚙️ Thông tin
                        </a>

                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout-link">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>

                
                <?php elseif ($role == 1): ?>
                
                <a href="<?= BASE_URL ?>/instructor/dashboard" class="nav-link">
                    📊 <span>Trang chủ</span>
                </a>

                <a href="<?= BASE_URL ?>/instructor/course/manage" class="nav-link">
                    📚 <span>Quản lý khóa học</span>
                </a>

                <a href="<?= BASE_URL ?>/teacher/lessons" class="nav-link">
                    📋 <span>Quản lý bài học</span>
                </a>

                <a href="<?= BASE_URL ?>/teacher/materials" class="nav-link">
                    📝 <span>Đăng tải tài liệu</span>
                </a>
                
                <div class="user-menu-wrapper">

                    <div class="user-info-toggle">
                        <img src="<?= htmlspecialchars($user['avatar_url'] ?? 'default_avatar.png') ?>"
                            class="user-avatar">

                        <span class="user-name">
                            <?= htmlspecialchars($user['username']) ?>
                        </span>
                    </div>

                    <div class="user-dropdown-content">
                        <div class="user-details-summary">
                            <p class="font-semibold">
                                <?= htmlspecialchars($user['username']) ?>
                            </p>

                            <p class="text-xs text-gray-400">Teacher</p>

                            <hr class="dropdown-hr">
                        </div>

                        <a href="<?= BASE_URL ?>/profile/change-avatar" class="dropdown-item">
                            🖼️ Thay đổi ảnh đại diện
                        </a>

                        <a href="<?= BASE_URL ?>/profile/info" class="dropdown-item">
                            ⚙️ Thông tin
                        </a>

                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout-link">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>


                <?php else: ?>

                <a href="<?= BASE_URL ?>/" class="nav-link">
                    🏠 <span>Trang chủ</span>
                </a>

                <a href="<?= BASE_URL ?>/courses" class="nav-link">
                    📚 <span>Khóa học</span>
                </a>

                <a href="<?= BASE_URL ?>/dashboard" class="nav-link">
                    📊 <span>Tùy chọn</span>
                </a>

                <a href="<?= BASE_URL ?>/my-courses" class="nav-link">
                    ✅ <span>Khóa học của tôi</span>
                </a>

                <a href="<?= BASE_URL ?>/course-progress" class="nav-link">
                    📈 <span>Tiến độ khóa học</span>
                </a>

                <div class="user-menu-wrapper">

                    <div class="user-info-toggle">
                        <img src="<?= htmlspecialchars($user['avatar_url'] ?? 'default_avatar.png') ?>"
                            class="user-avatar">

                        <span class="user-name">
                            <?= htmlspecialchars($user['username']) ?>
                        </span>
                    </div>

                    <div class="user-dropdown-content">
                        <div class="user-details-summary">
                            <p class="font-semibold">
                                <?= htmlspecialchars($user['username']) ?>
                            </p>

                            <p class="text-xs text-gray-400">Student</p>

                            <hr class="dropdown-hr">
                        </div>
                        <a href="<?= BASE_URL ?>/profile/change-avatar" class="dropdown-item">
                            🖼️ Thay đổi ảnh đại diện
                        </a>

                        <a href="<?= BASE_URL ?>/profile/info" class="dropdown-item">
                            ⚙️ Thông tin
                        </a>

                        <a href="<?= BASE_URL ?>/logout" class="dropdown-item logout-link">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>

            <?php endif; ?>


        </div>
    </div>
</nav>