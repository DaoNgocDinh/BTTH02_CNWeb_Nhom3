<?php
// Edit category view (expects $category variable)
$title = 'Edit Category';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="flex">
	<aside class="w-64 bg-gray-900 text-white p-6 hidden md:block">
		<h2 class="text-xl font-bold mb-2">Admin</h2>
		<nav class="space-y-2">
			<a href="/<?= basename(__DIR__) ?>/admin/dashboard" class="block px-3 py-2 rounded hover:bg-gray-800">📊 Dashboard</a>
			<a href="/<?= basename(__DIR__) ?>/admin/users" class="block px-3 py-2 rounded hover:bg-gray-800">👥 Users</a>
			<a href="/<?= basename(__DIR__) ?>/admin/categories" class="block px-3 py-2 rounded hover:bg-gray-800">📂 Categories</a>
			<a href="/<?= basename(__DIR__) ?>/admin/statistics" class="block px-3 py-2 rounded hover:bg-gray-800">📈 Statistics</a>
			<a href="/<?= basename(__DIR__) ?>/logout" class="block px-3 py-2 mt-4 text-red-400 hover:bg-red-900">Logout</a>
		</nav>
	</aside>

	<main class="flex-1 p-6">
		<h1 class="text-2xl font-bold mb-6">Edit Category</h1>

		<?php if (empty($category)): ?>
			<div class="bg-white p-6 rounded shadow text-gray-600">Category not found.</div>
		<?php else: ?>
			<div class="bg-white p-6 rounded shadow max-w-2xl">
				<form method="POST" action="/<?= basename(__DIR__) ?>/admin/categories/<?= urlencode($category['id']) ?>" class="space-y-4">
					<div>
						<label class="block text-sm font-medium">Name</label>
						<input type="text" name="name" required value="<?= htmlspecialchars($category['name'] ?? '') ?>" class="w-full border px-3 py-2 rounded" />
					</div>
					<div>
						<label class="block text-sm font-medium">Description</label>
						<textarea name="description" rows="4" class="w-full border px-3 py-2 rounded"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
					</div>
					<div class="flex gap-3">
						<button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
						<a href="/<?= basename(__DIR__) ?>/admin/categories" class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</a>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
