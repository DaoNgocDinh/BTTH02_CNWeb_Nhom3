<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-4xl font-extrabold mb-8 text-gray-800">Chỉnh Sửa Bài Học</h1>

		<div class="bg-white p-8 rounded-xl shadow">
			<form action="<?= BASE_URL ?>/instructor/lesson/update/<?= $lesson->id ?>" method="POST" class="space-y-6">
				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
					<input type="text" name="title" required value="<?= htmlspecialchars($lesson->title) ?>"
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Nội dung</label>
					<textarea name="content" rows="6"
					          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($lesson->content) ?></textarea>
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Video URL</label>
					<input type="text" name="video_url" value="<?= htmlspecialchars($lesson->video_url) ?>"
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Thứ tự <span class="text-red-500">*</span></label>
					<input type="number" name="order" required value="<?= $lesson->order ?>" min="1"
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div class="flex gap-4 pt-4">
					<button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
						Cập nhật
					</button>
					<a href="<?= BASE_URL ?>/instructor/lesson/manage" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
						Hủy
					</a>
				</div>
			</form>
		</div>
	</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
