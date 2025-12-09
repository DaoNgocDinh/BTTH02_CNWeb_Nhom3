<?php
// Create category view
$title = 'Create Category';
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
		<h1 class="text-2xl font-bold mb-6">Create Category</h1>

		<div class="bg-white p-6 rounded shadow max-w-2xl">
			<form method="POST" action="/BTTH02_CNWeb_Nhom3/admin/categories" class="space-y-4">
				<div>
					<label class="block text-sm font-medium">Name</label>
					<input type="text" name="name" required class="w-full border px-3 py-2 rounded" />
				</div>
				<div>
					<label class="block text-sm font-medium">Description</label>
					<textarea name="description" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
				</div>
				<div class="flex gap-3">
					<button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
					<a href="/BTTH02_CNWeb_Nhom3/admin/categories" class="bg-gray-600 text-white px-4 py-2 rounded">Cancel</a>
				</div>
			</form>
		</div>
	</main>
</div>

<?php require_once __DIR__ . '/../../views/layouts/footer.php'; ?>
