<?php
// Users management view
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';

// Get search and filter parameters from GET
$search = $_GET['search'] ?? '';
$role_filter = $_GET['role'] ?? '';
?>

<main class="p-8 bg-gray-100 min-h-screen">
	<div class="flex justify-between items-center mb-8">
		<h1 class="text-4xl font-extrabold text-gray-800">Manage Users</h1>
		<a href="<?= BASE_URL ?>/admin/users/create"
		   class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
			+ Create User
		</a>
	</div>

	<!-- Search & Filter -->
	<div class="bg-white p-6 rounded-xl shadow mb-6">
		<form method="GET" class="flex gap-4 flex-wrap">
			<input type="text" name="search" placeholder="Search username, email, fullname..." 
			       value="<?= htmlspecialchars($search) ?>"
			       class="flex-1 min-w-64 px-4 py-2 border rounded-lg">
			
			<select name="role" class="px-4 py-2 border rounded-lg">
				<option value="">All Roles</option>
				<option value="0" <?= $role_filter === '0' ? 'selected' : '' ?>>User</option>
				<option value="1" <?= $role_filter === '1' ? 'selected' : '' ?>>Teacher</option>
				<option value="2" <?= $role_filter === '2' ? 'selected' : '' ?>>Admin</option>
			</select>
			
			<button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
				Search
			</button>
			<a href="<?= BASE_URL ?>/admin/users" class="px-5 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
				Reset
			</a>
		</form>
	</div>

	<?php if (!empty($users)): ?>
		<div class="bg-white rounded-xl shadow overflow-auto">
			<table class="w-full text-left">
				<thead class="bg-gray-50 border-b">
					<tr>
						<th class="px-6 py-4 font-semibold text-gray-700">ID</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Username</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Email</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Fullname</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Role</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Created At</th>
						<th class="px-6 py-4 font-semibold text-gray-700">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user): ?>
						<tr class="border-b hover:bg-gray-50 transition">
							<td class="px-6 py-4"><?= htmlspecialchars($user['id'] ?? '') ?></td>
							<td class="px-6 py-4 font-semibold"><?= htmlspecialchars($user['username'] ?? '') ?></td>
							<td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($user['email'] ?? '') ?></td>
							<td class="px-6 py-4"><?= htmlspecialchars($user['fullname'] ?? '') ?></td>
							<td class="px-6 py-4">
								<span class="<?= $user['role'] == 2 ? 'bg-red-100 text-red-800' : ($user['role'] == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') ?> px-3 py-1 rounded-full text-xs font-semibold">
									<?= ($user['role'] == 2 ? 'Admin' : ($user['role'] == 1 ? 'Teacher' : 'User')) ?>
								</span>
							</td>
							<td class="px-6 py-4 text-sm text-gray-600">
								<?= isset($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'N/A' ?>
							</td>
							<td class="px-6 py-4 flex gap-3">
								<a href="<?= BASE_URL ?>/admin/users/<?= $user['id'] ?>/edit" class="text-blue-600 hover:underline">Edit</a>
								<button type="button" onclick="openDeleteModal(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')" class="text-red-600 hover:underline">Delete</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
			<p class="text-lg">No users found.</p>
		</div>
	<?php endif; ?>
</main>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
	<div class="bg-white rounded-xl shadow-lg p-8 max-w-sm mx-4">
		<h2 class="text-2xl font-bold mb-4 text-gray-800">Delete User</h2>
		<p class="text-gray-600 mb-6">
			Are you sure you want to delete user <span id="deleteUsername" class="font-semibold text-red-600"></span>? This action cannot be undone.
		</p>
		<div class="flex gap-4">
			<a id="confirmDeleteBtn" href="#" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg text-center hover:bg-red-700 transition">
				Delete
			</a>
			<button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
				Cancel
			</button>
		</div>
	</div>
</div>

<script>
function openDeleteModal(userId, username) {
	document.getElementById('deleteUsername').textContent = username;
	document.getElementById('confirmDeleteBtn').href = '<?= BASE_URL ?>/admin/users/' + userId + '/delete';
	document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
	document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
	if (e.target === this) {
		closeDeleteModal();
	}
});
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>