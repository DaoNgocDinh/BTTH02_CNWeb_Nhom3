<?php
$title = 'Edit User';
require_once __DIR__ . '/../../layouts/header.php';

// Lưu user cần edit vào biến khác trước khi sidebar ghi đè
$editUser = $user ?? null;

require_once __DIR__ . '/../../layouts/sidebar.php';

// Khôi phục user cần edit
$user = $editUser;
?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-4xl font-extrabold mb-8 text-gray-800">Edit User</h1>

		<?php if (empty($user)): ?>
			<div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
				<p class="text-lg">User not found.</p>
			</div>
		<?php else: ?>
			<div class="bg-white p-8 rounded-xl shadow">
				<form method="POST" action="<?= BASE_URL ?>/admin/users/<?= $user['id'] ?>" class="space-y-6">
					<div>
						<label class="block text-sm font-semibold mb-2 text-gray-700">ID</label>
						<input type="text" value="<?= htmlspecialchars($user['id']) ?>" disabled class="w-full border border-gray-300 px-4 py-2 rounded-lg bg-gray-100" />
					</div>

					<div>
						<label class="block text-sm font-semibold mb-2 text-gray-700">Username</label>
						<input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
					</div>

					<div>
						<label class="block text-sm font-semibold mb-2 text-gray-700">Email</label>
						<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
					</div>

					<div>
						<label class="block text-sm font-semibold mb-2 text-gray-700">Fullname</label>
						<input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
					</div>

					<div>
						<label class="block text-sm font-semibold mb-2 text-gray-700">Role</label>
						<select name="role" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
							<option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>User</option>
							<option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Teacher</option>
							<option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Admin</option>
						</select>
					</div>

					<div class="flex gap-4">
						<button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
							Update User
						</button>
						<a href="<?= BASE_URL ?>/admin/users" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
							Cancel
						</a>
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
