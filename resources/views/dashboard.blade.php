@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        background: linear-gradient(135deg, #4facfe 0%,rgb(122, 69, 183) 25%, #667eea 50%, #764ba2 75%, #5b73e8 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
    
    .floating-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: float 20s infinite linear;
    }
    
    .floating-shape:nth-child(1) {
        width: 200px;
        height: 200px;
        top: 10%;
        left: -5%;
        animation-delay: 0s;
    }
    
    .floating-shape:nth-child(2) {
        width: 150px;
        height: 150px;
        top: 60%;
        right: -5%;
        animation-delay: 7s;
    }
    
    .floating-shape:nth-child(3) {
        width: 100px;
        height: 100px;
        top: 30%;
        left: 70%;
        animation-delay: 14s;
    }
    
    .floating-shape:nth-child(4) {
        width: 120px;
        height: 120px;
        bottom: 20%;
        left: 20%;
        animation-delay: 3s;
    }
    
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
        50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
        75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
        100% { transform: translateY(0px) rotate(360deg); opacity: 0.3; }
    }
    
    .content-wrapper {
        position: relative;
        z-index: 2;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    .dashboard-title {
        color: #ffffff;
        font-size: 3rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 3rem;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
    }
    
    .status-card {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .status-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #667eea, #764ba2,rgb(125, 78, 220), #8e54e9);
        border-radius: 20px;
        z-index: -1;
        animation: borderGlow 3s ease-in-out infinite alternate;
    }
    
    @keyframes borderGlow {
        0% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .status-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    
    .status-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 1rem;
    }
    
    .status-card p {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
    }
    
    .card-todo p { color: #3b82f6; }
    .card-progress p { color: #f59e0b; }
    .card-done p { color: #10b981; }
    
    .filter-form {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .filter-form:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
    }
    
    .filter-label {
        font-weight: 700;
        color: #374151;
        font-size: 1.1rem;
    }
    
    .filter-select {
        background: #ffffff;
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .filter-button {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .filter-button:hover {
        background: linear-gradient(45deg, #5a67d8, #6b46c1);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }
    
    .chart-container {
        background: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        padding: 2.5rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .chart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .chart-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 70px rgba(0, 0, 0, 0.12);
    }
    
    .chart-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #374151;
        margin-bottom: 1.5rem;
        text-align: center;
        background: linear-gradient(45deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .filter-flex {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    /* Chart Wrapper untuk responsive */
    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 400px; /* Fixed height untuk desktop */
        overflow: hidden;
    }
    
    #burndownChart {
        width: 100% !important;
        height: 100% !important;
        max-width: 100%;
        display: block;
    }
    
    @media (min-width: 640px) {
        .filter-flex {
            flex-direction: row;
            align-items: center;
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem 0;
        }
        
        .dashboard-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .content-wrapper {
            padding: 0 1rem;
        }
        
        .status-card, .filter-form, .chart-container {
            padding: 1.5rem;
        }
        
        .status-card h3 {
            font-size: 1rem;
        }
        
        .status-card p {
            font-size: 2rem;
        }
        
        .grid-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        /* Mobile optimizations untuk chart */
        .chart-container {
            padding: 1rem;
            border-radius: 15px;
        }
        
        .chart-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .chart-wrapper {
            height: 300px; /* Lebih kecil untuk mobile */
        }
        
        .filter-form {
            padding: 1rem;
        }
        
        .filter-label {
            font-size: 1rem;
        }
        
        .filter-select, .filter-button {
            padding: 0.5rem;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 480px) {
        .dashboard-container {
            padding: 0.5rem 0;
        }
        
        .content-wrapper {
            padding: 0 0.5rem;
        }
        
        .dashboard-title {
            font-size: 1.5rem;
        }
        
        .status-card, .filter-form, .chart-container {
            padding: 1rem;
            border-radius: 12px;
        }
        
        .chart-wrapper {
            height: 250px; /* Lebih kecil lagi untuk layar sangat kecil */
        }
        
        .chart-title {
            font-size: 1.1rem;
        }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4); }
        70% { box-shadow: 0 0 0 20px rgba(102, 126, 234, 0); }
        100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
    }
</style>

<div class="dashboard-container">
    <div class="floating-elements">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    
    <div class="content-wrapper">
        <h1 class="dashboard-title">📈 Dashboard Produktivitas</h1>

        <!-- Status Cards -->
        <div class="grid-container">
            <div class="status-card card-todo">
                <h3>📝 To Do</h3>
                <p>{{ $countTodo }}</p>
            </div>
            <div class="status-card card-progress">
                <h3>🚧 Sedang Dikerjakan</h3>
                <p>{{ $countInProgress }}</p>
            </div>
            <div class="status-card card-done">
                <h3>✅ Selesai</h3>
                <p>{{ $countDone }}</p>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('dashboard') }}" method="GET" class="filter-form pulse-animation" id="filterForm">
            <div class="filter-flex">
                <label for="period" class="filter-label">🗓️ Pilih Periode:</label>
                <select id="period" name="period" class="filter-select">
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>📅 Hari Ini</option>
                    <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>📊 Minggu Ini</option>
                    <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>📈 Bulan Ini</option>
                </select>
                <button type="submit" class="filter-button">
                    ✨ Terapkan
                </button>
            </div>
        </form>

        <!-- Chart Section -->
        <div class="chart-container">
            <h2 class="chart-title">📉 Burndown Chart</h2>
            <div class="chart-wrapper">
                <canvas id="burndownChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('burndownChart').getContext('2d');
    const period = '{{ request("period", "week") }}';

    // Detect mobile device
    const isMobile = window.innerWidth <= 768;

    fetch(`/dashboard/status-chart-data?period=${period}`)
        .then(res => res.json())
        .then(data => {
            // Calculate maximum value across all datasets
            const maxTodo = Math.max(...data.todo);
            const maxInProgress = Math.max(...data.in_progress);
            const maxDone = Math.max(...data.done);
            const maxDataValue = Math.max(maxTodo, maxInProgress, maxDone);
            
            // Set y-axis max to either max value + 1 or 5 (whichever is higher)
            const yAxisMax = Math.max(maxDataValue + 1, 5);

            // Mobile-optimized configuration
            const mobileConfig = {
                responsive: true,
                maintainAspectRatio: false, // Important untuk mobile
                devicePixelRatio: window.devicePixelRatio || 1,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: yAxisMax,
                        ticks: { 
                            font: { size: isMobile ? 8 : 10 },
                            stepSize: 1,
                            precision: 0,
                            maxTicksLimit: isMobile ? 6 : 8 // Batasi jumlah tick di mobile
                        },
                        grid: {
                            display: !isMobile // Sembunyikan grid di mobile
                        }
                    },
                    x: {
                        ticks: { 
                            font: { size: isMobile ? 8 : 10 },
                            maxTicksLimit: isMobile ? 5 : 10, // Batasi label di mobile
                            maxRotation: isMobile ? 45 : 0 // Rotasi label di mobile
                        },
                        grid: {
                            display: !isMobile
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: isMobile ? 'bottom' : 'bottom',
                        labels: {
                            boxWidth: isMobile ? 8 : 10,
                            font: { size: isMobile ? 8 : 10 },
                            padding: isMobile ? 8 : 12,
                            usePointStyle: isMobile // Gunakan point style di mobile
                        }
                    },
                    tooltip: {
                        enabled: true,
                        titleFont: { size: isMobile ? 10 : 12 },
                        bodyFont: { size: isMobile ? 9 : 11 }
                    }
                },
                layout: {
                    padding: isMobile ? { top: 5, bottom: 5, left: 5, right: 5 } : { top: 10, bottom: 10 }
                },
                elements: {
                    point: {
                        radius: isMobile ? 2 : 3, // Poin lebih kecil di mobile
                        hoverRadius: isMobile ? 4 : 6
                    },
                    line: {
                        borderWidth: isMobile ? 1.5 : 2 // Garis lebih tipis di mobile
                    }
                }
            };

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [
                        {
                            label: 'To Do',
                            data: data.todo,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(39, 105, 212, 0.1)',
                            tension: 0.3,
                            fill: false,
                            pointRadius: isMobile ? 2 : 3
                        },
                        {
                            label: 'Sedang Dikerjakan',
                            data: data.in_progress,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.3,
                            fill: false,
                            pointRadius: isMobile ? 2 : 3
                        },
                        {
                            label: 'Selesai',
                            data: data.done,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 78, 185, 0.1)',
                            tension: 0.3,
                            fill: false,
                            pointRadius: isMobile ? 2 : 3
                        },
                        {
                            label: 'Ideal Burndown',
                            data: data.ideal,
                            borderColor: '#9ca3af',
                            borderDash: [5, 5],
                            fill: false,
                            tension: 0,
                            pointRadius: 0
                        }
                    ]
                },
                options: mobileConfig
            });
        })
        .catch(err => console.error("Chart Error:", err));

    // Handle window resize
    window.addEventListener('resize', function() {
        // Chart.js akan handle resize otomatis dengan responsive: true
    });
});
</script>
@endpush