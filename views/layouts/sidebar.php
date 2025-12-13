<nav class="navbar">
    <div class="navbar-container">
        <?php
        $user = $_SESSION['user'] ?? null;
        if ($user && $user['role'] == 1) {
            $homeLink = BASE_URL . '/instructor/dashboard';
        } else {
            $homeLink = BASE_URL . '/';
        }
        ?>
        <a href="<?= $homeLink ?>" class="navbar-logo">
            65KTPM
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

                        <a href="<?= BASE_URL ?>/profile" class="dropdown-item">
                            ⚙️ Thông tin cá nhân
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

                <div class="user-menu-wrapper">

                    <div class="user-info-toggle">
                        <span>Tôi:</span>
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

                        <a href="<?= BASE_URL ?>/profile" class="dropdown-item">
                            ⚙️ Thông tin cá nhân
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

                <a href="<?= BASE_URL ?>/my-courses" class="nav-link">
                    ✅ <span>Khóa học của tôi</span>
                </a>

                <a href="<?= BASE_URL ?>/course-progress" class="nav-link">
                    📈 <span>Tiến độ khóa học</span>
                </a>

                <div class="user-menu-wrapper">

                    <div class="user-info-toggle">
                        
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

                        <a href="<?= BASE_URL ?>/profile" class="dropdown-item">
                            ⚙️ Thông tin cá nhân
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