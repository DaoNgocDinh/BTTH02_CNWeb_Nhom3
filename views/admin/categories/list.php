<?php
// Categories list view
$title = 'Manage Categories';
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
		<h1 class="text-2xl font-bold mb-6">Categories</h1>

		<?php if (!empty($categories)): ?>
			<div class="bg-white rounded shadow overflow-auto">
				<table class="w-full text-left">
					<thead class="bg-gray-50 border-b">
						<tr>
							<th class="px-4 py-3">ID</th>
							<th class="px-4 py-3">Name</th>
							<th class="px-4 py-3">Description</th>
							<th class="px-4 py-3">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($categories as $cat): ?>
							<tr class="border-b hover:bg-gray-50">
								<td class="px-4 py-3"><?= htmlspecialchars($cat['id'] ?? '') ?></td>
								<td class="px-4 py-3 font-semibold"><?= htmlspecialchars($cat['name'] ?? '') ?></td>
								<td class="px-4 py-3 text-gray-600"><?= htmlspecialchars(substr($cat['description'] ?? '', 0, 80)) ?></td>
								<td class="px-4 py-3">
									<a href="/<?= basename(__DIR__) ?>/admin/categories/<?= $cat['id'] ?>/edit" class="text-blue-600 hover:underline">Edit</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<div class="bg-white p-6 rounded shadow text-center text-gray-600">No categories found.</div>
		<?php endif; ?>
	</main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
