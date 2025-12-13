<?php require_once __DIR__ . '/../../layouts/header.php'; 
require_once __DIR__ . '/../../layouts/sidebar.php';?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="flex justify-between items-center mb-8">
		<h1 class="text-4xl font-extrabold text-gray-800">Quản lý thể loại</h1>
		<a href="<?= BASE_URL ?>/admin/categories/create"
		   class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
			+ Thêm thể loại
		</a>
	</div>

	<?php if (!empty($_SESSION['flash'])): ?>
		<div class="mb-6 p-4 <?= ($_SESSION['flash']['type'] ?? 'success') === 'error' ? 'bg-red-100 text-red-800 border-red-400' : 'bg-green-100 text-green-800 border-green-400' ?> border rounded-lg">
			<?= htmlspecialchars($_SESSION['flash']['message'] ?? '') ?>
		</div>
		<?php unset($_SESSION['flash']); ?>
	<?php endif; ?>

	<?php if (!empty($categories)): ?>
		<div class="bg-white rounded-xl shadow overflow-auto">
			<table class="w-full text-left">
				<thead class="bg-gray-50 border-b">
					<tr>
						<th class="px-6 py-4 font-semibold text-gray-700">ID</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Tên thể loại</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Mô tả</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($categories as $cat): ?>
						<tr class="border-b hover:bg-gray-50 transition">
							<td class="px-6 py-4"><?= htmlspecialchars($cat['id']) ?></td>
							<td class="px-6 py-4 font-semibold"><?= htmlspecialchars($cat['name']) ?></td>
							<td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($cat['description']) ?></td>
							<td class="px-6 py-4 flex gap-3">
								<a href="<?= BASE_URL ?>/admin/categories/<?= $cat['id'] ?>/edit" class="text-blue-600 hover:underline">Edit</a>
								<a href="<?= BASE_URL ?>/admin/categories/<?= $cat['id'] ?>/delete" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
			<p class="text-lg">Không có thể loại nào.</p>
		</div>
	<?php endif; ?>
</main>
