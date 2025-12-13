<?php require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-4xl font-extrabold mb-8 text-gray-800">Thêm thể loại mới</h1>

		<div class="bg-white p-8 rounded-xl shadow">
			<form action="<?= BASE_URL ?>/admin/categories" method="POST" class="space-y-6">
				<div>
					<label for="name" class="block text-sm font-semibold mb-2 text-gray-700">Tên thể loại</label>
					<input type="text" id="name" name="name" required
					       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>
				<div>
					<label for="description" class="block text-sm font-semibold mb-2 text-gray-700">Mô tả</label>
					<textarea id="description" name="description" rows="5"
					          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
				</div>
				<div class="flex gap-4">
					<button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
						Lưu
					</button>
					<a href="<?= BASE_URL ?>/admin/categories" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
						Hủy
					</a>
				</div>
			</form>
		</div>
	</div>
</main>