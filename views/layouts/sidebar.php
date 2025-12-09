<!-- TOP NAVBAR -->
<nav class="w-full bg-gradient-to-r from-gray-900 to-gray-800 text-white px-6 py-4 shadow-lg">
    <div class="flex items-center justify-between">

        <!-- LEFT: Logo -->
        <h2 class="text-2xl font-bold tracking-wide">
            MY APP
        </h2>

        <!-- RIGHT: Menu Items & User Info -->
        <div class="flex items-center gap-6 text-sm font-medium">

            <a href="<?= BASE_URL ?>/admin/dashboard"
               class="flex items-center gap-1 hover:text-blue-400 transition">
                📊 <span>Dashboard</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/users"
               class="flex items-center gap-1 hover:text-blue-400 transition">
                👥 <span>Users</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/categories"
               class="flex items-center gap-1 hover:text-blue-400 transition">
                📂 <span>Categories</span>
            </a>

            <a href="<?= BASE_URL ?>/admin/statistics"
               class="flex items-center gap-1 hover:text-blue-400 transition">
                📈 <span>Statistics</span>
            </a>

            <span class="text-gray-500">|</span>

            <div class="text-right">
                <p class="font-semibold"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></p>
                <p class="text-xs text-gray-400"><?= $_SESSION['user']['role'] == 0 ? 'Administrator' : 'User' ?></p>
            </div>

            <a href="<?= BASE_URL ?>/logout"
               class="flex items-center gap-1 text-red-300 hover:text-red-500 transition">
                🚪 <span>Logout</span>
            </a>
        </div>
    </div>
</nav>
