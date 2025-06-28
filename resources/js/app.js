// Import CSS utama Tailwind
import Chart from 'chart.js/auto';

import '../css/app.css';

// Import jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Setup CSRF token untuk semua AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// Fungsi delete task
function deleteTask(taskId) {
    if (confirm('Yakin ingin menghapus tugas ini?')) {
        $.ajax({
            url: `/tasks/${taskId}`,
            type: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Gagal menghapus tugas!');
                console.error(xhr.responseText);
            }
        });
    }
}
window.deleteTask = deleteTask;
