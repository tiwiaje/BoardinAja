@extends('layouts.app')

@section('content')
<style>
    .calendar-wrapper {
        background: linear-gradient(135deg, #4facfe 0%,rgb(226, 64, 235) 20%, #667eea 40%,rgb(51, 63, 131) 60%,rgb(106, 84, 233) 80%, #667eea 100%);
        background-size: 400% 400%;
        animation: gradientFlow 20s ease infinite;
        min-height: 100vh;
        padding: 1rem 0;
        position: relative;
        overflow: hidden;
    }
    
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        25% { background-position: 100% 50%; }
        50% { background-position: 100% 100%; }
        75% { background-position: 0% 100%; }
        100% { background-position: 0% 50%; }
    }
    
    .floating-orbs {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
    
    .orb {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 15s infinite ease-in-out;
    }
    
    .orb:nth-child(1) {
        width: 150px;
        height: 150px;
        top: 10%;
        left: 5%;
        animation-delay: 0s;
    }
    
    .orb:nth-child(2) {
        width: 100px;
        height: 100px;
        top: 70%;
        right: 10%;
        animation-delay: 5s;
    }
    
    .orb:nth-child(3) {
        width: 80px;
        height: 80px;
        top: 40%;
        left: 80%;
        animation-delay: 10s;
    }
    
    .orb:nth-child(4) {
        width: 120px;
        height: 120px;
        bottom: 15%;
        left: 15%;
        animation-delay: 2s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
        25% { transform: translateY(-30px) rotate(90deg); opacity: 0.6; }
        50% { transform: translateY(-60px) rotate(180deg); opacity: 0.3; }
        75% { transform: translateY(-30px) rotate(270deg); opacity: 0.6; }
    }
    
    .calendar-container {
        position: relative;
        z-index: 2;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .calendar-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: all 0.4s ease;
        position: relative;
        border: 2px solid transparent;
        background-clip: padding-box;
    }
    
    .calendar-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg,rgb(139, 113, 242),rgb(0, 131, 254), #667eea,rgb(86, 119, 203), #8e54e9);
        border-radius: 20px;
        z-index: -1;
        animation: borderGlow 4s ease-in-out infinite alternate;
    }
    
    @keyframes borderGlow {
        0% { opacity: 0.6; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.01); }
    }
    
    .calendar-header {
        background: linear-gradient(135deg, #667eea 0%,rgb(184, 114, 255) 50%, #8e54e9 100%);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .calendar-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        animation: shimmer 4s infinite;
        transform: rotate(45deg);
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    
    .calendar-title {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 900;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-align: center;
        justify-content: center;
    }
    
    .calendar-content {
        padding: 1rem;
        background: #ffffff;
        position: relative;
    }
    
    .calendar-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2, #8e54e9);
        animation: progressBar 3s ease-in-out infinite;
    }
    
    @keyframes progressBar {
        0%, 100% { transform: scaleX(0); transform-origin: left; }
        50% { transform: scaleX(1); transform-origin: left; }
    }
    
    /* Tablet styles */
    @media (max-width: 1024px) {
        .calendar-container {
            padding: 0 0.75rem;
        }
        
        .calendar-title {
            font-size: 1.6rem;
        }
    }
    
    /* Mobile specific styles */
    @media (max-width: 768px) {
        .calendar-wrapper {
            padding: 0.5rem 0;
        }
        
        .calendar-container {
            padding: 0 0.5rem;
        }
        
        .calendar-card {
            border-radius: 15px;
            margin: 0;
        }
        
        .calendar-card::before {
            border-radius: 15px;
        }
        
        .calendar-header {
            padding: 1rem;
        }
        
        .calendar-title {
            font-size: 1.4rem;
            gap: 0.3rem;
        }
        
        .calendar-content {
            padding: 0.75rem;
        }
        
        /* Hide floating orbs on mobile for better performance */
        .floating-orbs {
            display: none;
        }
        
        /* Disable hover effects on mobile */
        .calendar-card:hover {
            transform: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
    }
    
    @media (max-width: 480px) {
        .calendar-wrapper {
            padding: 0.25rem 0;
        }
        
        .calendar-container {
            padding: 0 0.25rem;
        }
        
        .calendar-header {
            padding: 0.75rem;
        }
        
        .calendar-title {
            font-size: 1.2rem;
        }
        
        .calendar-content {
            padding: 0.5rem;
        }
    }
</style>

<div class="calendar-wrapper">
    <div class="floating-orbs">
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
    </div>
    
    <div class="calendar-container">
        <div class="calendar-card">
            <div class="calendar-header">
                <h1 class="calendar-title">
                    📅 Kalender Tugas
                </h1>
            </div>
            <div class="calendar-content">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Enhanced FullCalendar Styling with Mobile Responsiveness */
.fc {
    --fc-border-color: #e2e8f0;
    --fc-today-bg-color: linear-gradient(135deg, #eff6ff, #dbeafe);
    --fc-page-bg-color: white;
    --fc-neutral-bg-color: #f8fafc;
    --fc-highlight-color: rgba(102, 126, 234, 0.15);
}

.fc .fc-button {
    background: linear-gradient(135deg, #ffffff, #f8fafc) !important;
    border: 2px solid transparent !important;
    color: #374151 !important;
    font-weight: 600 !important;
    padding: 0.5rem 1rem !important;
    border-radius: 12px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    position: relative !important;
    overflow: hidden !important;
    font-size: 0.9rem !important;
}

.fc .fc-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.2), transparent);
    transition: left 0.5s ease;
}

.fc .fc-button:hover {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    color: white !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
    border-color: #667eea !important;
}

.fc .fc-button:hover::before {
    left: 100%;
}

.fc .fc-button-primary:not(:disabled).fc-button-active {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    border-color: #667eea !important;
    color: white !important;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
}

.fc .fc-button-primary:disabled {
    background: #f3f4f6 !important;
    border-color: #d1d5db !important;
    color: #9ca3af !important;
    cursor: not-allowed !important;
    box-shadow: none !important;
}

/* Fixed toolbar layout to prevent title overlapping */
.fc .fc-toolbar {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 0.5rem !important;
    margin-bottom: 1rem !important;
    padding: 0.5rem !important;
}

.fc .fc-toolbar-chunk {
    display: flex !important;
    align-items: center !important;
    gap: 0.25rem !important;
}

.fc .fc-toolbar-title {
    font-size: 1.3rem !important;
    font-weight: 800 !important;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none !important;
    text-align: center !important;
    margin: 0 !important;
    line-height: 1.2 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    min-width: 0 !important;
    flex: 1 !important;
}

.fc .fc-daygrid-day-number {
    color: #374151 !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    padding: 0.3rem !important;
    transition: all 0.2s ease !important;
}

.fc .fc-day-today {
    background: linear-gradient(135deg, #eff6ff, #dbeafe) !important;
    position: relative !important;
}

.fc .fc-day-today::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 2px solid #667eea;
    border-radius: 6px;
    pointer-events: none;
    animation: todayGlow 2s ease-in-out infinite alternate;
}

@keyframes todayGlow {
    0% { box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
    100% { box-shadow: 0 0 15px rgba(102, 126, 234, 0.6); }
}

.fc .fc-day-today .fc-daygrid-day-number {
    color: #667eea !important;
    font-weight: 800 !important;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 50%;
    width: 1.8rem;
    height: 1.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0.2rem;
}

.fc .fc-event {
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    border: none !important;
    color: white !important;
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    padding: 3px 6px !important;
    border-radius: 6px !important;
    margin: 1px !important;
    box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3) !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}

.fc .fc-event:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.5) !important;
}

.fc .fc-daygrid-event-dot {
    border-color: #667eea !important;
    background: #667eea !important;
}

.fc .fc-daygrid-day:hover {
    background: rgba(102, 126, 234, 0.05) !important;
    transition: background 0.2s ease !important;
}

.fc .fc-col-header-cell {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0) !important;
    font-weight: 700 !important;
    color: #374151 !important;
    border-bottom: 2px solid #667eea !important;
    padding: 0.8rem 0.3rem !important;
    font-size: 0.85rem !important;
}

.fc .fc-scrollgrid {
    border: 1px solid #e2e8f0 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
}

.fc .fc-daygrid-day-frame {
    min-height: 80px !important;
    padding: 0.3rem !important;
}

/* Tablet-specific FullCalendar styles */
@media (max-width: 1024px) {
    .fc .fc-toolbar {
        gap: 0.4rem !important;
        padding: 0.4rem !important;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1.2rem !important;
    }
    
    .fc .fc-button {
        padding: 0.4rem 0.8rem !important;
        font-size: 0.85rem !important;
    }
}

/* Mobile-specific FullCalendar styles */
@media (max-width: 768px) {
    .fc .fc-toolbar {
        flex-direction: column !important;
        gap: 0.5rem !important;
        padding: 0.5rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .fc .fc-toolbar-chunk {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 0.3rem !important;
        width: 100% !important;
    }
    
    /* Title first, then navigation */
    .fc .fc-toolbar-chunk:nth-child(2) {
        order: -1 !important;
        margin-bottom: 0.3rem !important;
    }
    
    .fc .fc-button {
        padding: 0.35rem 0.6rem !important;
        font-size: 0.75rem !important;
        border-radius: 8px !important;
        min-width: 45px !important;
        white-space: nowrap !important;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1rem !important;
        text-align: center !important;
        margin: 0 !important;
        line-height: 1.2 !important;
        word-break: normal !important;
        max-width: 100% !important;
        white-space: nowrap !important;
        overflow: visible !important;
        text-overflow: clip !important;
        padding: 0.2rem 0.5rem !important;
        font-weight: 700 !important;
        flex: none !important;
        min-width: auto !important;
        width: auto !important;
    }
    
    .fc .fc-daygrid-day-frame {
        min-height: 70px !important;
        padding: 0.25rem !important;
    }
    
    .fc .fc-daygrid-day-number {
        font-size: 0.8rem !important;
        padding: 0.2rem !important;
    }
    
    .fc .fc-day-today .fc-daygrid-day-number {
        width: 1.6rem;
        height: 1.6rem;
        margin: 0.1rem;
    }
    
    .fc .fc-event {
        font-size: 0.7rem !important;
        padding: 2px 4px !important;
        border-radius: 4px !important;
        margin: 1px 0 !important;
    }
    
    .fc .fc-col-header-cell {
        padding: 0.5rem 0.2rem !important;
        font-size: 0.75rem !important;
    }
    
    .fc .fc-scrollgrid {
        border-radius: 10px !important;
    }
    
    /* Disable hover effects on mobile */
    .fc .fc-button:hover {
        transform: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
    
    .fc .fc-event:hover {
        transform: none !important;
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3) !important;
    }
    
    .fc .fc-daygrid-day:hover {
        background: transparent !important;
    }
}

@media (max-width: 480px) {
    .fc .fc-toolbar {
        gap: 0.4rem !important;
        padding: 0.4rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .fc .fc-toolbar-chunk {
        gap: 0.25rem !important;
    }
    
    .fc .fc-toolbar-chunk:nth-child(2) {
        margin-bottom: 0.25rem !important;
    }
    
    .fc .fc-button {
        padding: 0.3rem 0.5rem !important;
        font-size: 0.7rem !important;
        min-width: 40px !important;
        border-radius: 6px !important;
    }
    
    .fc .fc-toolbar-title {
        font-size: 0.9rem !important;
        padding: 0.15rem 0.3rem !important;
        line-height: 1.1 !important;
        font-weight: 600 !important;
        letter-spacing: -0.3px !important;
    }
    
    .fc .fc-daygrid-day-frame {
        min-height: 60px !important;
        padding: 0.2rem !important;
    }
    
    .fc .fc-daygrid-day-number {
        font-size: 0.75rem !important;
        padding: 0.15rem !important;
    }
    
    .fc .fc-day-today .fc-daygrid-day-number {
        width: 1.4rem;
        height: 1.4rem;
    }
    
    .fc .fc-event {
        font-size: 0.65rem !important;
        padding: 1px 3px !important;
    }
    
    .fc .fc-col-header-cell {
        padding: 0.4rem 0.1rem !important;
        font-size: 0.7rem !important;
    }
}

/* Extra small screens */
@media (max-width: 360px) {
    .fc .fc-toolbar-title {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        line-height: 1.0 !important;
        letter-spacing: -0.5px !important;
        padding: 0.1rem 0.2rem !important;
    }
    
    .fc .fc-button {
        padding: 0.25rem 0.4rem !important;
        font-size: 0.65rem !important;
        min-width: 35px !important;
    }
    
    .fc .fc-daygrid-day-frame {
        min-height: 50px !important;
    }
}

/* Landscape orientation for mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .fc .fc-toolbar {
        flex-direction: row !important;
        gap: 0.4rem !important;
        justify-content: space-between !important;
    }
    
    .fc .fc-toolbar-chunk {
        flex-wrap: nowrap !important;
        width: auto !important;
    }
    
    .fc .fc-toolbar-chunk:nth-child(2) {
        order: 0 !important;
        margin-bottom: 0 !important;
        flex: 1 !important;
        justify-content: center !important;
    }
    
    .fc .fc-toolbar-title {
        font-size: 0.95rem !important;
    }
    
    .fc .fc-daygrid-day-frame {
        min-height: 45px !important;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .fc .fc-button {
        border-width: 1px !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        
        // Enhanced mobile detection
        const isMobile = window.innerWidth <= 768;
        const isSmallMobile = window.innerWidth <= 480;
        const isTablet = window.innerWidth > 768 && window.innerWidth <= 1024;
        
        // Dynamic view selection based on screen size
        let initialView = 'dayGridMonth';
        let headerToolbar = {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        };
        
        if (isMobile) {
            initialView = isSmallMobile ? 'listWeek' : 'dayGridMonth';
            headerToolbar = {
                left: 'prev,next',
                center: 'title',
                right: isSmallMobile ? 'dayGridMonth,listWeek' : 'dayGridMonth,timeGridWeek,listWeek'
            };
        } else if (isTablet) {
            headerToolbar = {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            };
        }
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: initialView,
    height: isMobile ? (isSmallMobile ? 350 : 450) : (isTablet ? 500 : 600),
    aspectRatio: isMobile ? (isSmallMobile ? 1.1 : 1.25) : (isTablet ? 1.3 : 1.35),
    headerToolbar: headerToolbar,
    buttonText: {
        today: 'Hari Ini',
        month: 'Bulan',
        week: 'Minggu',
        list: 'Daftar'
    },
    locale: 'id',
    firstDay: 1,
    events: function(fetchInfo, successCallback, failureCallback) {
        fetch('{{ route('calendar.events') }}')
            .then(response => response.json())
            .then(events => successCallback(events))
            .catch(error => failureCallback(error));
    },
    eventClick: function(info) {
        info.jsEvent.preventDefault();
        if (info.event.url) {
            window.location.href = info.event.url;
        }
    },
    dateClick: function(info) {
        const selectedDate = info.dateStr;
        window.location.href = `{{ route('tasks.create') }}?date=${selectedDate}`;
    },
    eventDisplay: 'block',
    eventBackgroundColor: '#667eea',
    eventBorderColor: '#667eea',
    eventTextColor: '#ffffff',
    dayMaxEvents: isMobile ? (isSmallMobile ? 1 : 2) : true,
    navLinks: true,
    nowIndicator: true,
    editable: false,
    selectable: false,
    dayMaxEventRows: isMobile ? (isSmallMobile ? 1 : 2) : false,
    moreLinkClick: 'popover',
    eventLimitClick: 'popover',
    stickyHeaderDates: !isMobile,
    fixedWeekCount: false,
    showNonCurrentDates: !isSmallMobile,
    lazyFetching: true,
    eventDidMount: function(info) {
        if (isMobile && info.event.title) {
            info.el.setAttribute('title', info.event.title);
        }
    }
});


        calendar.render();
        calendar.refetchEvents();
        
        // Enhanced resize handler with debouncing
        let resizeTimer;
        let currentScreenType = isMobile ? 'mobile' : (isTablet ? 'tablet' : 'desktop');
        
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const newWidth = window.innerWidth;
                let newScreenType = 'desktop';
                
                if (newWidth <= 768) {
                    newScreenType = 'mobile';
                } else if (newWidth <= 1024) {
                    newScreenType = 'tablet';
                }
                
                // Reload if screen type changed significantly
                if (newScreenType !== currentScreenType) {
                    location.reload();
                } else {
                    calendar.updateSize();
                }
            }, 300);
        });
        
        // Handle orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                calendar.updateSize();
            }, 500);
        });

        
        // Touch-friendly event handling for mobile
        if (isMobile) {
            calendar.setOption('eventClick', function(info) {
                info.jsEvent.preventDefault();
                // Add haptic feedback if available
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            });
        }
    });
</script>
@endpush
