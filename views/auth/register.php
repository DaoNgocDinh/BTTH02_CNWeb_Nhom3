<?php
$title = 'Đăng ký';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-md bg-white/90 backdrop-blur shadow-xl p-8 rounded-2xl border border-gray-200">

        <h2 class="text-3xl font-bold text-center mb-6
                   bg-gradient-to-r from-blue-600 to-indigo-600
                   bg-clip-text text-transparent">
            Đăng ký tài khoản
        </h2>

        <?php
        if (!empty($_SESSION['flash'])) {
            $f = $_SESSION['flash'];
            $isSuccess = $f['type'] === 'success';
            echo "
                <div class='p-4 mb-4 rounded-lg border 
                ".($isSuccess ? "bg-blue-50 border-blue-400 text-blue-700"
                             : "bg-red-50 border-red-400 text-red-700")."'>
                    ".htmlspecialchars($f['message'])."
                </div>
            ";
            unset($_SESSION['flash']);
        }

        $old = $_SESSION['old'] ?? [];
        ?>

        <form method="POST" action="/BTTH02_CNWeb_Nhom3/register" class="space-y-5" novalidate>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input 
                    type="text" 
                    name="username" 
                    required
                    value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-xl shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fullname</label>
                <input 
                    type="text" 
                    name="fullname"
                    class="w-full px-4 py-2 border rounded-xl shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-xl shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-2 border rounded-xl shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                />
            </div>

            <button 
                type="submit"
                class="w-full py-2.5 rounded-xl text-white font-medium
                       bg-gradient-to-r from-blue-600 to-indigo-600
                       hover:from-blue-700 hover:to-indigo-700
                       transition shadow-md">
                Đăng ký
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Đã có tài khoản?
            <a href="/BTTH02_CNWeb_Nhom3/login"
               class="text-blue-600 hover:underline font-medium">
                Đăng nhập
            </a>
        </p>

    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
