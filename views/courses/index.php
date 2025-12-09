<?php
$title = 'Browse Courses';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- MAIN -->
<main class="p-8 bg-gray-100 min-h-screen">

    <!-- TITLE + SEARCH -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Browse Courses</h1>
        
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search"
                       placeholder="Search courses by name or description..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- COURSES GRID -->
    <?php if (!empty($courses)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <!-- Course Image (Placeholder) -->
                    <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                        <span class="text-6xl">📚</span>
                    </div>

                    <!-- Course Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                            <?= htmlspecialchars($course['name']) ?>
                        </h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            <?= htmlspecialchars($course['description'] ?? 'No description available') ?>
                        </p>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-blue-600">
                                <?= !empty($course['price']) ? '$' . number_format($course['price'], 2) : 'Free' ?>
                            </span>
                        </div>

                        <a href="<?= BASE_URL ?>/courses/<?= $course['id'] ?>"
                           class="w-full block text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white p-12 text-center rounded-xl shadow">
            <p class="text-xl text-gray-600 mb-4">No courses available yet.</p>
            <a href="<?= BASE_URL ?>/dashboard"
               class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Back to Dashboard
            </a>
        </div>
    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
