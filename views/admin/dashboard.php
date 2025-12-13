<?php
$title = 'Admin Dashboard';
require_once __DIR__ . '/../../views/layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- MAIN WRAPPER -->
<main class="p-8 bg-gray-100 min-h-screen">

    <!-- TITLE -->
    <h1 class="text-4xl font-extrabold mb-8 text-gray-800">Trang tổng quan của quản trị viên</h1>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="p-6 rounded-xl shadow-2xl bg-gradient-to-r from-black to-gray-600 text-white">
            <h3 class="text-sm opacity-80">Tổng số người dùng</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_users'] ?? 0) ?></p>
        </div>

        <div class="p-6 rounded-xl shadow bg-gradient-to-r from-gray-700 via-gray-900 to-gray-700 text-white">
            <h3 class="text-sm opacity-80">Tổng số khóa học</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_courses'] ?? 0) ?></p>
        </div>

        <div class="p-6 rounded-xl shadow bg-gradient-to-l from-black to-gray-600 text-white">
            <h3 class="text-sm opacity-80">Tổng số khóa học</h3>
            <p class="text-4xl font-bold mt-2"><?= htmlspecialchars($stats['total_categories'] ?? 0) ?></p>
        </div>

    </div>

    <!-- CHART -->
    <div class="bg-white p-6 rounded-xl shadow mb-10">
        <h2 class="text-xl font-semibold mb-5 text-gray-700">Mức tăng trưởng người dùng trong tuần</h2>

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
