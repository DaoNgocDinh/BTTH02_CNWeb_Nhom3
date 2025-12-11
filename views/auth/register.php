<?php
$title = 'Đăng ký';
require_once __DIR__ . '/../layouts/header.php';

$old = $_SESSION['old'] ?? [];
?>

<div class="auth-page">
    <div class="auth-left">
        <div class="auth-card">

            <h2 class="auth-title">Đăng ký tài khoản</h2>

            <?php
            if (!empty($_SESSION['flash'])) {
                $f = $_SESSION['flash'];
                $isSuccess = $f['type'] === 'success';
                echo "
                <div class='flash " . ($isSuccess ? "flash-success" : "flash-error") . "'>
                    " . htmlspecialchars($f['message']) . "
                </div>
            ";
                unset($_SESSION['flash']);
            }
            ?>

            <form method="POST" action="<?= BASE_URL ?>/register" class="form" novalidate>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        required
                        value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                        class="input" />
                </div>

                <div class="form-group">
                    <label class="form-label">Fullname</label>
                    <input
                        type="text"
                        name="fullname"
                        value="<?= htmlspecialchars($old['fullname'] ?? '') ?>"
                        class="input" />
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        required
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        class="input" />
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="input" />
                </div>

                <button type="submit" class="btn">Đăng ký</button>
            </form>

            <p class="text-muted">
                Đã có tài khoản?
                <a href="<?= BASE_URL ?>/login" class="link">Đăng nhập</a>
            </p>
        </div>
    </div>
    <div class="auth-right">
        <div class="auth-panel">
            <div class="panel-title">Chào mừng bạn đến với 2TĐ</div>
            <div class="panel-sub">Học lập trình để đi làm</div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>