<?php
$title = 'Đăng nhập';
require_once __DIR__ . '/../layouts/header.php';

$old = $_SESSION['old'] ?? [];
?>

<div class="auth-page">
    <div class="auth-left">
        <div class="auth-card">

            <h2 class="auth-title">Đăng nhập</h2>

            <?php
            if (!empty($_SESSION['flash'])) {
                $f = $_SESSION['flash'];
                $isSuccess = $f['type'] === 'success';
                echo "
                    <div class='flash ".($isSuccess ? "flash-success" : "flash-error")."'>
                        ".htmlspecialchars($f['message'])."
                    </div>
                ";
                unset($_SESSION['flash']);
            }
            ?>

            <form method="POST" action="<?= BASE_URL ?>/login" class="form" novalidate>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        required 
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        class="input"
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="input"
                    />
                </div>

                <button type="submit" class="btn">Đăng nhập</button>
            </form>

            <p class="text-muted">
                Chưa có tài khoản? 
                <a href="<?= BASE_URL ?>/register" class="link">Đăng ký</a>
            </p>

        </div>
    </div>

    <div class="auth-right">
        <div class="auth-panel">
            <h2 class="panel-title">Chào mừng bạn quay trở lại 2TĐ</h2>
            <p class="panel-sub">Hãy viết tiếp hành trình của bạn!</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>