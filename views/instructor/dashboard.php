<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../layouts/sidebar.php'; 
?>

<div class="min-h-screen bg-gradient-to-b from-slate-100 to-slate-200 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <div class="inline-block">
                <h1 class="text-5xl md:text-5xl font-bold bg-gradient-to-r from-slate-700 to-amber-700 bg-clip-text text-transparent mb-4">
                    Khóa học của tôi
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-slate-700 to-amber-700 rounded-full"></div>
            </div>
        </div>

        <?php if (!empty($coursesWithStudents)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($coursesWithStudents as $item):
                    $course = $item['course'];
                    $students = $item['students'];
                    $imagePath = !empty($course->image) ? BASE_URL . '/assets/uploads/courses/' . $course->image : BASE_URL . '/assets/uploads/courses/default.jpg';
                ?>

                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-4 transform flex flex-col relative border border-gray-100">
                    
                    <!-- STUDENT COUNT BADGE -->
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-slate-700 to-amber-700 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg z-10 backdrop-blur-sm">
                        👥 <?= count($students) ?>
                    </div>

                    <!-- IMAGE CONTAINER -->
                    <div class="relative overflow-hidden h-48 bg-gray-200">
                        <img 
                            src="<?= $imagePath ?>" 
                            alt="<?= htmlspecialchars($course->title) ?>"
                            class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                    </div>

                    <!-- BODY -->
                    <div class="p-5 flex flex-col flex-grow bg-white">
                        
                        <!-- TITLE -->
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-slate-700 transition-colors">
                            <?= htmlspecialchars($course->title) ?>
                        </h3>

                        <!-- DESCRIPTION -->
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed flex-grow">
                            <?= htmlspecialchars($course->description) ?>
                        </p>

                        <!-- INFO GRID -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="group/info bg-gradient-to-br from-slate-50 to-slate-100 p-3 rounded-lg border border-slate-300 hover:border-slate-400 transition-all">
                                <p class="text-xs font-semibold text-slate-700 uppercase tracking-wide">Thể loại</p>
                                <p class="text-sm font-bold text-gray-900 truncate group-hover/info:text-slate-700"><?= htmlspecialchars($course->category_id) ?></p>
                            </div>
                            <div class="group/info bg-gradient-to-br from-amber-50 to-amber-100 p-3 rounded-lg border border-amber-300 hover:border-amber-400 transition-all">
                                <p class="text-xs font-semibold text-amber-700 uppercase tracking-wide">Level</p>
                                <p class="text-sm font-bold text-gray-900 group-hover/info:text-amber-700"><?= htmlspecialchars($course->level) ?></p>
                            </div>
                            <div class="group/info bg-gradient-to-br from-stone-50 to-stone-100 p-3 rounded-lg border border-stone-300 hover:border-stone-400 transition-all">
                                <p class="text-xs font-semibold text-stone-700 uppercase tracking-wide">Giá</p>
                                <p class="text-sm font-bold text-gray-900 group-hover/info:text-stone-700"><?= number_format($course->price) ?> ₫</p>
                            </div>
                            <div class="group/info bg-gradient-to-br from-zinc-50 to-zinc-100 p-3 rounded-lg border border-zinc-300 hover:border-zinc-400 transition-all">
                                <p class="text-xs font-semibold text-zinc-700 uppercase tracking-wide">Thời lượng</p>
                                <p class="text-sm font-bold text-gray-900 group-hover/info:text-zinc-700"><?= $course->duration_weeks ?> tuần</p>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <a 
                            href="<?= BASE_URL ?>/instructor/course/<?= $course->id ?>/lessons"
                            class="w-full py-2 px-4 bg-gradient-to-r from-slate-700 to-amber-700 hover:from-slate-800 hover:to-amber-800 text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-slate-400 active:scale-95 text-xs inline-block text-center mb-4 cursor-pointer border-0"
                        >
                            Xem bài học
                        </a>



                    </div>
                </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 bg-white/10 backdrop-blur-md rounded-2xl">
                <div class="text-6xl mb-4"></div>
                <p class="text-white text-2xl font-semibold mb-2">Chưa có khóa học nào.</p>
                <p class="text-white/80">Hãy tạo khóa học đầu tiên của bạn</p>
            </div>
        <?php endif; ?>
    </div>
</div>
