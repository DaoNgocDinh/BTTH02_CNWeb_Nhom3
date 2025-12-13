<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-4xl font-extrabold mb-8 text-gray-800">Thêm Bài Học Mới</h1>

		<div class="bg-white p-8 rounded-xl shadow">
			<form action="<?= BASE_URL ?>/instructor/lesson/store/<?= $course->id ?>" method="POST" class="space-y-6">
				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
					<input type="text" name="title" required
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Nội dung</label>
					<textarea name="content" rows="6"
					          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Video URL</label>
					<input type="text" name="video_url"
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Thứ tự <span class="text-red-500">*</span></label>
					<input type="number" name="order" required value="1" min="1"
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div class="flex gap-4 pt-4">
					<button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
						Thêm bài học
					</button>
					<a href="<?= BASE_URL ?>/instructor/course/<?= $course_id ?>/lessons" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
						Hủy
					</a>
				</div>
			</form>
		</div>
	</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
