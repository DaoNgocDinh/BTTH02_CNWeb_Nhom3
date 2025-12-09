<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- MAIN WRAPPER -->
<main class="p-8 bg-gray-100 min-h-screen">

    <!-- TITLE -->
    <h1 class="text-4xl font-extrabold mb-8 text-gray-800">Admin Dashboard</h1>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="p-6 rounded-xl shadow bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            <h3 class="text-sm opacity-80">Total Users</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_users'] ?? 0) ?></p>
        </div>

        <div class="p-6 rounded-xl shadow bg-gradient-to-r from-green-500 to-green-600 text-white">
            <h3 class="text-sm opacity-80">Total Courses</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_courses'] ?? 0) ?></p>
        </div>

        <div class="p-6 rounded-xl shadow bg-gradient-to-r from-purple-500 to-purple-600 text-white">
            <h3 class="text-sm opacity-80">Total Categories</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_categories'] ?? 0) ?></p>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-5 text-gray-700">Quick Actions</h2>

        <div class="flex flex-wrap gap-4">
            <a href="<?= BASE_URL ?>/admin/users"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Manage Users
            </a>

            <a href="<?= BASE_URL ?>/admin/categories"
               class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Manage Categories
            </a>

            <a href="<?= BASE_URL ?>/admin/categories/create"
               class="px-5 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800 transition">
                Create Category
            </a>
        </div>
    </div>

    <!-- CHART -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-5 text-gray-700">User Growth This Week</h2>

        <canvas id="userChart" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'New Users',
                    data: [5, 8, 12, 6, 10, 4, 14],
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</main>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
