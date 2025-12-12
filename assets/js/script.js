document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-detail');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const detail = this.closest('.course-progress-item').querySelector('.course-detail');
            if (detail.style.display === 'none' || detail.style.display === '') {
                detail.style.display = 'block';
                this.textContent = 'Ẩn chi tiết';
            } else {
                detail.style.display = 'none';
                this.textContent = 'Xem chi tiết';
            }
        });
    });
});