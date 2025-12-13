<?php
// Statistics view
$title = 'Statistics';
require_once __DIR__ . '/../../views/layouts/header.php';
?>

<div class="flex">
	<aside class="w-64 bg-gray-900 text-white p-6 hidden md:block">
		<h2 class="text-xl font-bold mb-2">Admin</h2>
		<nav class="space-y-2">
			<a href="/BTTH02_CNWeb_Nhom3/admin/dashboard" class="block px-3 py-2 rounded hover:bg-gray-800">📊 Dashboard</a>
			<a href="/BTTH02_CNWeb_Nhom3/admin/users" class="block px-3 py-2 rounded hover:bg-gray-800">👥 Users</a>
			<a href="/BTTH02_CNWeb_Nhom3/admin/categories" class="block px-3 py-2 rounded hover:bg-gray-800">📂 Categories</a>
			<a href="/BTTH02_CNWeb_Nhom3/admin/statistics" class="block px-3 py-2 rounded hover:bg-gray-800">📈 Statistics</a>
			<a href="/BTTH02_CNWeb_Nhom3/logout" class="block px-3 py-2 mt-4 text-red-400 hover:bg-red-900">Logout</a>
		</nav>
	</aside>

	<main class="flex-1 p-6">
		<h1 class="text-2xl font-bold mb-6">Statistics</h1>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
			<div class="bg-white p-6 rounded shadow">
				<h3 class="text-sm text-gray-500">Total Users</h3>
				<p class="text-2xl font-bold"><?= $stats['total_users'] ?? 0 ?></p>
			</div>
			<div class="bg-white p-6 rounded shadow">
				<h3 class="text-sm text-gray-500">Total Courses</h3>
				<p class="text-2xl font-bold"><?= $stats['total_courses'] ?? 0 ?></p>
			</div>
			<div class="bg-white p-6 rounded shadow">
				<h3 class="text-sm text-gray-500">Total Categories</h3>
				<p class="text-2xl font-bold"><?= $stats['total_categories'] ?? 0 ?></p>
			</div>
		</div>

		<div class="bg-white p-6 rounded shadow">
			<h2 class="text-lg font-semibold mb-2">Recent Activity</h2>
			<p class="text-gray-600">No recent activity available.</p>
		</div>
	</main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
