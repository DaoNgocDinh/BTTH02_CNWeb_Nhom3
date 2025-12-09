<?php
$title = 'Create User';
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-4xl font-extrabold mb-8 text-gray-800">Create New User</h1>

		<div class="bg-white p-8 rounded-xl shadow">
			<form method="POST" action="<?= BASE_URL ?>/admin/users" class="space-y-6">
				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Username</label>
					<input type="text" name="username" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Email</label>
					<input type="email" name="email" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Password</label>
					<input type="password" name="password" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Fullname</label>
					<input type="text" name="fullname" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
				</div>

				<div>
					<label class="block text-sm font-semibold mb-2 text-gray-700">Role</label>
					<select name="role" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="0">Admin</option>
						<option value="1" selected>User</option>
					</select>
				</div>

				<div class="flex gap-4">
					<button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
						Create User
					</button>
					<a href="<?= BASE_URL ?>/admin/users" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
						Cancel
					</a>
				</div>
			</form>
		</div>
	</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
