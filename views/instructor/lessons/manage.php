<?php
$title = "Quản lý bài học: " . htmlspecialchars($course->title);
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="min-h-screen bg-gradient-to-b from-slate-100 to-slate-200 p-8">
	<div class="max-w-6xl mx-auto">
		<!-- Header -->
		<div class="flex justify-between items-center mb-8">
			<div>
				<a href="<?= BASE_URL ?>/instructor/dashboard" class="text-slate-600 hover:text-slate-800 mb-2 inline-block">
					← Quay lại Dashboard
				</a>
				<h1 class="text-4xl font-bold bg-gradient-to-r from-slate-700 to-amber-700 bg-clip-text text-transparent">
					<?= htmlspecialchars($course->title) ?>
				</h1>
			</div>
			<a href="<?= BASE_URL ?>/instructor/lesson/create/<?= $course->id ?>"
			   class="px-6 py-3 bg-gradient-to-r from-slate-700 to-amber-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-300">
				+ Thêm bài học
			</a>
		</div>

		<!-- Success/Error Messages -->
		<?php if (isset($_SESSION['success'])): ?>
			<div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-400 rounded-lg shadow-md animate-in">
				 <?= htmlspecialchars($_SESSION['success']) ?>
			</div>
			<?php unset($_SESSION['success']); ?>
		<?php endif; ?>

		<?php if (isset($_SESSION['error'])): ?>
			<div class="mb-6 p-4 bg-red-100 text-red-800 border border-red-400 rounded-lg shadow-md">
				 <?= htmlspecialchars($_SESSION['error']) ?>
			</div>
			<?php unset($_SESSION['error']); ?>
		<?php endif; ?>

		<?php if (!empty($lessons)): ?>
			<!-- Lessons Table -->
			<div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
				<table class="w-full text-left">
					<thead class="bg-gradient-to-r from-slate-100 to-slate-200 border-b border-slate-300">
						<tr>
							<th class="px-6 py-4 font-bold text-slate-700">ID</th>
							<th class="px-6 py-4 font-bold text-slate-700">Tiêu đề bài học</th>
							<th class="px-6 py-4 font-bold text-slate-700">Thứ tự</th>
							<th class="px-6 py-4 font-bold text-slate-700">Hành động</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($lessons as $lesson): ?>
							<tr class="border-b border-slate-200 hover:bg-slate-50 transition duration-200">
								<td class="px-6 py-4 text-slate-600 font-medium"><?= $lesson->id ?></td>
								<td class="px-6 py-4 font-semibold text-gray-900"><?= htmlspecialchars($lesson->title) ?></td>
								<td class="px-6 py-4 text-slate-600 font-medium"><?= $lesson->order ?></td>
								<td class="px-6 py-4">
									<div class="flex gap-2 flex-wrap items-center">
										<a href="<?= BASE_URL ?>/instructor/lesson/edit/<?= $lesson->id ?>" 
										   class="px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-sm font-semibold transition duration-200">
											 Sửa
										</a>
										<a href="<?= BASE_URL ?>/instructor/lesson/delete/<?= $lesson->id ?>" 
										   class="px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-semibold transition duration-200"
										   onclick="return confirm('Xóa bài học này? Dữ liệu không thể khôi phục!')">
											 Xóa
										</a>
									</div>
								</td>
							</tr>
							<!-- Materials Upload Row -->
							<tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
								<td colspan="4" class="px-6 py-4">
									<form action="<?= BASE_URL ?>/instructor/lesson/upload/<?= $lesson->id ?>" method="POST" enctype="multipart/form-data" class="flex gap-3 items-center flex-wrap">
										<label class="text-sm font-semibold text-slate-700">📎 Tài liệu:</label>
										<input type="file" name="files[]" multiple class="text-sm border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500" />
										<button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200">
											 Upload
										</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php else: ?>
			<div class="bg-white p-12 rounded-2xl shadow-lg text-center">
				<p class="text-2xl text-slate-600 font-semibold mb-4"> Chưa có bài học nào</p>
				<a href="<?= BASE_URL ?>/instructor/lesson/create/<?= $course->id ?>"
				   class="inline-block px-6 py-3 bg-gradient-to-r from-slate-700 to-amber-700 text-white font-bold rounded-lg hover:shadow-lg transition">
					+ Tạo bài học đầu tiên
				</a>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>