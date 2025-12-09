<?php
$title = htmlspecialchars($course['title']);
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- MAIN -->
<main class="p-8 bg-gray-100 min-h-screen">

    <!-- BACK BUTTON -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>/courses"
           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
            ← Back to Courses
        </a>
    </div>

    <!-- COURSE HEADER -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Course Image -->
            <div class="md:col-span-1">
                <div class="w-full h-64 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-8xl">📚</span>
                </div>
            </div>

            <!-- Course Info -->
            <div class="md:col-span-2">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">
                    <?= htmlspecialchars($course['title']) ?>
                </h1>

                <p class="text-gray-600 text-lg mb-6">
                    <?= htmlspecialchars($course['description'] ?? 'No description available') ?>
                </p>

                <div class="mb-6">
                    <p class="text-3xl font-bold text-blue-600 mb-4">
                        <?= !empty($course['price']) ? '$' . number_format($course['price'], 2) : 'Free' ?>
                    </p>

                    <button class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Enroll Now
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Duration</p>
                        <p class="font-semibold text-gray-800"><?= $course['duration_weeks'] ?? '-' ?> weeks</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Level</p>
                        <p class="font-semibold text-gray-800"><?= $course['level'] ?? 'Beginner' ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Course ID</p>
                        <p class="font-semibold text-gray-800"><?= $course['id'] ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600">Created</p>
                        <p class="font-semibold text-gray-800"><?= date('d/m/Y', strtotime($course['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- COURSE CONTENT -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- MAIN CONTENT -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">About This Course</h2>
                <p class="text-gray-600 leading-relaxed">
                    This course provides comprehensive learning on the subject matter. 
                    You will gain practical skills and knowledge applicable to real-world scenarios.
                </p>

                <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">What You'll Learn</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold mt-1">✓</span>
                        <span>Fundamental concepts and best practices</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold mt-1">✓</span>
                        <span>Hands-on practical projects</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold mt-1">✓</span>
                        <span>Industry-standard tools and techniques</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold mt-1">✓</span>
                        <span>Certificate of completion</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- SIDEBAR -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Course Stats</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">Students</span>
                        <span class="font-semibold text-gray-800">0</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">Lessons</span>
                        <span class="font-semibold text-gray-800">0</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-semibold text-gray-800"><?= $course['duration_weeks'] ?? '-' ?> weeks</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Level</span>
                        <span class="font-semibold text-gray-800"><?= $course['level'] ?? 'Beginner' ?></span>
                    </div>
                </div>

                <button class="w-full mt-6 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Enroll Now
                </button>
            </div>
        </div>

    </div>

</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
