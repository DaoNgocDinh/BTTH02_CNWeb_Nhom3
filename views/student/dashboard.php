<?php
$title = 'Student Dashboard';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- MAIN -->
<main class="p-8 bg-gray-100 min-h-screen">

    <!-- TITLE -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Welcome back, <?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']) ?>!</h1>
        <p class="text-gray-600 mt-2">Continue your learning journey</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Courses Enrolled -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Courses Enrolled</p>
                    <p class="text-4xl font-bold mt-2">0</p>
                </div>
                <div class="text-5xl opacity-20">📚</div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">In Progress</p>
                    <p class="text-4xl font-bold mt-2">0</p>
                </div>
                <div class="text-5xl opacity-20">🔄</div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-green-100 text-sm font-medium">Completed</p>
                    <p class="text-4xl font-bold mt-2">0</p>
                </div>
                <div class="text-5xl opacity-20">✅</div>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="<?= BASE_URL ?>/courses" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow">
                Browse Courses
            </a>
            <a href="<?= BASE_URL ?>/my-courses" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow">
                My Courses
            </a>
            <a href="<?= BASE_URL ?>/profile" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition shadow">
                My Profile
            </a>
        </div>
    </div>

    <!-- RECENT COURSES -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Recent Courses</h2>
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">You haven't enrolled in any courses yet.</p>
            <a href="<?= BASE_URL ?>/courses" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Explore Courses
            </a>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
