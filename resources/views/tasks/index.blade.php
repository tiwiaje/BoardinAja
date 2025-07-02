@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<!-- Pastikan CSRF token tersedia -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div style="position:fixed; inset:0; z-index:0; min-height:100vh; width:100vw; background:linear-gradient(-45deg, #667eea, #764ba2, #667eea, #764ba2); background-size:400% 400%; animation:gradientBG 15s ease infinite; overflow:hidden;">
    <div class="bubble" style="width: 200px; height: 200px; top: 10%; left: 5%; animation-delay: 0s; position:absolute;"></div>
    <div class="bubble" style="width: 150px; height: 150px; top: 70%; left: 80%; animation-delay: 2s; position:absolute;"></div>
    <div class="bubble" style="width: 100px; height: 100px; top: 30%; left: 60%; animation-delay: 4s; position:absolute;"></div>
    <div class="bubble" style="width: 250px; height: 250px; top: 50%; left: 20%; animation-delay: 6s; position:absolute;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 80%; left: 30%; animation-delay: 8s; position:absolute;"></div>
</div>

<a href="{{ route('dashboard') }}" class="btn btn-primary" style="position: fixed; top: 24px; left: 32px; z-index: 1100; background: #fff; color: #2563eb; border: 2px solid #2563eb; padding: 10px 22px; border-radius: 25px; font-weight: 600; box-shadow: 0 2px 8px rgba(102,126,234,0.10); text-decoration: none; display: flex; align-items: center; gap: 8px; transition: background 0.2s;">
    <i class="fas fa-arrow-left" style="color: #2563eb;"></i> Kembali ke Dashboard
</a>

<style>
.blink {
  animation: blink-animation 1.5s infinite;
}
@keyframes blink-animation {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}
.popup-card {
  position: absolute;
  top: 60px;
  right: 30px;
  background: white;
  border: 1px solid #ccc;
  padding: 1rem;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  z-index: 999;
}
.hidden { display: none; }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .bubble {
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        animation: floatBubble 15s ease-in-out infinite;
        z-index: 1;
    }
    
    @keyframes floatBubble {
        0%, 100% { transform: translateY(0) translateX(0); }
        25% { transform: translateY(-20px) translateX(10px); }
        50% { transform: translateY(0) translateX(20px); }
        75% { transform: translateY(20px) translateX(10px); }
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
        padding-top: 80px;
    }

    /* Navbar Styles */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover {
        transform: scale(1.05);
    }

    .navbar-brand i {
        font-size: 1.8rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .navbar-nav {
        display: flex;
        list-style: none;
        gap: 30px;
        align-items: center;
    }

    .nav-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 25px;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-link:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        transform: translateY(-2px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .navbar-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .navbar-toggle:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .mobile-menu {
        display: none;
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        z-index: 999;
        transition: all 0.3s ease;
    }

    .mobile-nav {
        list-style: none;
        padding: 1rem;
    }

    .mobile-nav .nav-link {
        display: block;
        padding: 0.5rem 1rem;
        margin-bottom: 0.5rem;
        text-align: center;
        border-radius: 10px;
    }

    .mobile-nav .nav-link:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .mobile-nav .nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        padding: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .mobile-menu-toggle:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    /* Animations */
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .slide-in {
        animation: slide-in 0.3s ease-out;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fade-in 0.4s ease-in-out forwards;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .navbar-nav {
            display: none;
        }
        .mobile-menu {
            display: block;
        }
        .mobile-menu-toggle {
            display: block;
        }
        .navbar-brand i {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .navbar-brand i {
            font-size: 1.6rem;
        }
    }

    /* Bubble Elements */
    .bubble {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        animation: floatBubble 15s ease-in-out infinite;
        z-index: -1;
    }

    #priority-popup {
        position: fixed;
        top: 90px;
        right: 1.5rem;
        background-color: white;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        z-index: 999;
        max-width: 320px;
        width: fit-content;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    @media (max-width: 600px) {
        #priority-popup {
            left: 2.5vw !important;
            right: 2.5vw !important;
            top: 70px !important;
            bottom: auto !important;
            width: 95vw !important;
            max-width: 95vw !important;
            border-radius: 0.7rem !important;
            padding: 0.5rem 0.5rem 0.8rem 0.5rem !important;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.13);
            border: none;
        }
        .priority-popup-header {
            font-size: 0.9rem;
            padding-bottom: 0.2rem;
        }
        .priority-popup-title {
            font-size: 0.9rem;
        }
        .priority-popup-content {
            font-size: 0.88rem;
        }
        .priority-item {
            padding: 6px;
            margin-bottom: 5px;
        }
        .priority-item-title {
            font-size: 0.8rem;
        }
        .priority-item-deadline {
            font-size: 0.65rem;
        }
        .priority-item-badge {
            font-size: 0.6rem;
            padding: 2px 6px;
        }
    }

    .priority-popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .priority-popup-title {
        font-size: 1rem;
        font-weight: 700;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .priority-popup-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #888;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .priority-popup-close:hover {
        color: #333;
        transform: scale(1.1);
    }

    .priority-item {
        background: #f9f9f9;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }

    .priority-item:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
    }

    .priority-item.urgent {
        border-left-color: #ff4757;
    }

    .priority-item.high {
        border-left-color: #ff6b35;
    }

    .priority-item.normal {
        border-left-color: #26a69a;
    }

    .priority-item-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .priority-item-deadline {
        font-size: 0.75rem;
        color: #666;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .priority-item-badge {
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-item-badge.urgent {
        background: #ff4757;
        color: white;
    }

    .priority-item-badge.high {
        background: #ff6b35;
        color: white;
    }

    .priority-item-badge.normal {
        background: #26a69a;
        color: white;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .header {
        text-align: center;
        color: white;
        margin-bottom: 30px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .priority-filter {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 0.9rem;
    }

    .filter-btn.all {
        background: #ffffff;
        color: #333;
    }

    .filter-btn.urgent {
        background: #ff4757;
        color: white;
    }

    .filter-btn.high {
        background: #ff6b35;
        color: white;
    }

    .filter-btn.normal {
        background: #26a69a;
        color: white;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .filter-btn.active {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .board {
        display: flex;
        gap: 25px;
        margin-top: 20px;
        overflow-x: auto;
        padding: 0 10px 20px 10px;
        justify-content: center;
    }

    .column {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        backdrop-filter: blur(15px);
        min-width: 400px;
        width: 400px;
        height: 600px;
        flex: 0 0 400px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .column:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .column-header {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 25px;
        padding: 15px;
        border-radius: 15px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        flex-shrink: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .column-header.todo {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .column-header.in-progress {
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
    }

    .column-header.completed {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
    }

    .task-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 18px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        border-left: 6px solid;
        transition: all 0.3s ease;
        cursor: move;
        position: relative;
        overflow: hidden;
        min-height: 120px;
        flex-shrink: 0;
        backdrop-filter: blur(5px);
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Priority Colors - Border Left */
    .task-card.urgent {
        border-left-color: #ff4757;
    }

    .task-card.high {
        border-left-color: #ff6b35;
    }

    .task-card.normal {
        border-left-color: #26a69a;
    }

    /* Priority Badge */
    .priority-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .priority-badge.urgent {
        background: #ff4757;
        color: white;
    }

    .priority-badge.high {
        background: #ff6b35;
        color: white;
    }

    .priority-badge.normal {
        background: #26a69a;
        color: white;
    }

    .task-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        padding-right: 60px;
    }

    .task-description {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .task-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #888;
        flex-wrap: wrap;
        gap: 5px;
    }

    .task-deadline {
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 15px;
    }

    .task-deadline.overdue {
        background: #ffebee;
        color: #c62828;
        font-weight: 600;
    }

    .task-category {
        background: #e3f2fd;
        color: #1976d2;
        padding: 4px 8px;
        border-radius: 15px;
        font-weight: 500;
    }

    .task-completed {
        background: #e8f5e8;
        color: #2e7d32;
        padding: 4px 8px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .add-task-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .add-task-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #5a6fd1, #6a4299);
    }

    /* Task Statistics */
    .stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        padding: 15px 25px;
        border-radius: 15px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        min-width: 120px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .task-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .task-actions form {
        display: inline-block;
    }

    .task-actions button,
    .task-actions .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .task-actions button:hover,
    .task-actions .btn:hover {
        transform: translateY(-1px);
    }

    .btn-warning {
        background: #ffc107;
        color: #333;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .hidden {
        display: none !important;
    }

    /* Loading state untuk drag and drop */
    .task-card.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
        pointer-events: none;
    }

    .sortable-ghost {
        opacity: 0.4;
        background: #f0f0f0;
    }

    /* Responsive Design */
    @media (max-width: 1400px) {
        .column {
            min-width: 350px;
            width: 350px;
            flex: 0 0 350px;
        }
    }

    @media (max-width: 1200px) {
        .column {
            min-width: 320px;
            width: 320px;
            flex: 0 0 320px;
            height: 550px;
        }
    }

    @media (max-width: 768px) {
        .navbar-nav {
            display: none;
        }
        .navbar-toggle {
            display: block;
        }
        .container {
            padding: 10px;
        }
        .header h1 {
            font-size: 2rem;
        }
        .header p {
            font-size: 1rem;
        }
        .board {
            flex-direction: column;
            overflow-x: visible;
            align-items: center;
            gap: 20px;
        }
        .column {
            min-width: 95%;
            width: 95%;
            flex: 1;
            height: 500px;
            max-width: 500px;
        }
        .priority-filter {
            gap: 10px;
        }
        .filter-btn {
            padding: 10px 18px;
            font-size: 0.8rem;
        }
        #priority-popup {
            top: 80px;
            right: 10px;
            left: 10px;
            width: auto;
            max-width: none;
        }
        .stats {
            gap: 15px;
        }
        .stat-card {
            padding: 12px 20px;
            min-width: 100px;
        }
        .stat-number {
            font-size: 1.3rem;
        }
        .stat-label {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        body {
            padding-top: 70px;
        }
        .navbar-container {
            height: 60px;
            padding: 0 15px;
        }
        .navbar-brand {
            font-size: 1.3rem;
        }
        .column {
            min-width: 100%;
            width: 100%;
            height: 450px;
            padding: 20px;
        }
        .board {
            padding: 0 5px 20px 5px;
            gap: 15px;
        }
        .filter-btn {
            padding: 8px 15px;
            font-size: 0.75rem;
        }
        .stats {
            gap: 10px;
        }
        .stat-card {
            padding: 10px 15px;
            min-width: 80px;
        }
        .task-card {
            padding: 15px;
            min-height: 100px;
        }
        .task-title {
            font-size: 1rem;
            padding-right: 50px;
        }
        .task-description {
            font-size: 0.85rem;
        }
        .priority-badge {
            font-size: 0.6rem;
            padding: 3px 6px;
        }
    }

    /* Custom scrollbar for columns */
    .column::-webkit-scrollbar {
        width: 6px;
    }

    .column::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
    }

    .column::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 3px;
    }

    .column::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.5);
    }

    /* Board scrollbar */
    .board::-webkit-scrollbar {
        height: 8px;
    }

    .board::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .board::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
    }

    .board::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<div class="container" style="position:relative; z-index:2;">
    <div class="header">
        <h1>📋 Task Management Board</h1>
        <p>Kelola tugas dengan prioritas warna yang jelas dan efisien</p>
    </div>

    <!-- Statistics -->
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number" id="totalTasks">0</div>
            <div class="stat-label">Total Tasks</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="urgentTasks">0</div>
            <div class="stat-label">Urgent</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="highTasks">0</div>
            <div class="stat-label">High</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="normalTasks">0</div>
            <div class="stat-label">Normal</div>
        </div>
    </div>

    <!-- Priority Filter -->
    <div class="priority-filter">
        <button class="filter-btn all active" onclick="filterTasks('all')">
            <i class="fas fa-list"></i> Semua
        </button>
        <button class="filter-btn urgent" onclick="filterTasks('urgent')">
            🔴 Urgent
        </button>
        <button class="filter-btn high" onclick="filterTasks('high')">
            🟠 High
        </button>
        <button class="filter-btn normal" onclick="filterTasks('normal')">
            🟢 Normal
        </button>
    </div>

    <!-- Task Board -->
    <div class="board">
        <!-- To Do Column -->
        <div class="column" data-status="todo">
            <div class="column-header todo">📝 To Do</div>
            <button class="add-task-btn" onclick="addTask('todo')">
                <i class="fas fa-plus"></i> Tambah Task
            </button>
            @foreach ($todoTasks as $task)
            <div class="task-card {{ $task->priority }}" data-priority="{{ $task->priority }}" data-task-id="{{ $task->id }}">
                <div class="priority-badge {{ $task->priority }}">{{ ucfirst($task->priority) }}</div>
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-description">{{ $task->description }}</div>
                <div class="task-meta">
                    <span class="task-deadline {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'overdue' : '' }}">
                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                    </span>
                    @if($task->category)
                    <span class="task-category">{{ $task->category }}</span>
                    @endif
                </div>
                <div class="task-actions">
                    {{-- Mark as Done button --}}
                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                        @csrf
                        <button type="submit">✔ Selesai</button>
                    </form>
                    <div class="task-actions">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($todoTasks->isEmpty())
            <p class="text-muted">Tidak ada tugas yang perlu dikerjakan.</p>
            @endif
        </div>

        <!-- In Progress Column -->
        <div class="column" data-status="in_progress">
            <div class="column-header in-progress">📝 In Progress</div>
            @foreach($inProgressTasks as $task)
            <div class="task-card {{ $task->priority }}" data-priority="{{ $task->priority }}" data-task-id="{{ $task->id }}">
                <div class="priority-badge {{ $task->priority }}">{{ ucfirst($task->priority) }}</div>
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-description">{{ $task->description }}</div>
                <div class="task-meta">
                    <span class="task-deadline {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'overdue' : '' }}">
                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                    </span>
                    @if($task->category)
                    <span class="task-category">{{ $task->category }}</span>
                    @endif
                    <div class="task-actions">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Completed Column -->
        <div class="column" data-status="done">
            <div class="column-header completed">📝 Completed</div>
            <button class="add-task-btn" onclick="addTask('done')">+ Tambah Task</button>
            @foreach($completedTasks as $task)
            <div class="task-card {{ $task->priority }}" data-priority="{{ $task->priority }}" data-task-id="{{ $task->id }}">
                <div class="priority-badge {{ $task->priority }}">{{ ucfirst($task->priority) }}</div>
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-description">{{ $task->description }}</div>
                <div class="task-meta">
                    <span class="task-deadline {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'overdue' : '' }}">
                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                    </span>
                    @if($task->category)
                    <span class="task-category">{{ $task->category }}</span>
                    @endif
                    <div class="task-actions">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if($task->completed_at)
                <span class="task-completed">
                    ✅ Diselesaikan: {{ \Carbon\Carbon::parse($task->completed_at)->diffForHumans() }}
                </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@if ($suggestedTasks->count())
<div id="priority-popup" class="animate-fade-in" style="z-index:10;">
    <div class="priority-popup-header">
        <div class="priority-popup-title">
            <i class="fas fa-bell" style="color: #667eea;"></i>
            <span>Saran Prioritas</span>
        </div>
        <button id="close-popup" class="priority-popup-close">&times;</button>
    </div>
    <div class="priority-popup-content">
        @foreach ($suggestedTasks->take(3) as $task)
        <div class="priority-item {{ $task->priority }}">
            <div class="priority-item-title">{{ $task->title }}</div>
            <div class="priority-item-deadline">
                <i class="far fa-clock"></i>
                <span>{{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}</span>
            </div>
            <div class="priority-item-badge {{ $task->priority }}">
                Prioritas: {{ ucfirst($task->priority) }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif{{-- Tombol Saran Prioritas yang berkedip --}}
    <div class="mb-4 relative">
        <button id="prioritySuggestionBtn" class="blink px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            💡 Saran Prioritas
        </button>

        {{-- Popup detail saran --}}
        <div id="priorityPopup" class="hidden popup-card absolute right-0 mt-2 bg-white border border-gray-300 shadow-lg rounded p-4 w-72 z-50">
            <div class="flex justify-between items-start">
                <p class="text-sm text-gray-700">Saran prioritas kamu adalah mengerjakan tugas yang paling dekat deadline-nya terlebih dahulu atau tugas dengan prioritas tertinggi.</p>
                <button onclick="document.getElementById('priorityPopup').classList.add('hidden')" class="ml-2 text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
        </div>
    </div>

<script>
    // Global functions
    function filterTasks(priority) {
        const allTasks = document.querySelectorAll('.task-card');
        const filterBtns = document.querySelectorAll('.filter-btn');
        
        filterBtns.forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.querySelector(`.filter-btn.${priority}`);
        if (activeBtn) activeBtn.classList.add('active');

        allTasks.forEach(task => {
            if (priority === 'all' || task.dataset.priority === priority) {
                task.classList.remove('hidden');
            } else {
                task.classList.add('hidden');
            }
        });
        
        updateStats();
    }

    function updateStats() {
        document.getElementById('totalTasks').textContent = document.querySelectorAll('.task-card:not(.hidden)').length;
        document.getElementById('urgentTasks').textContent = document.querySelectorAll('.task-card[data-priority="urgent"]:not(.hidden)').length;
        document.getElementById('highTasks').textContent = document.querySelectorAll('.task-card[data-priority="high"]:not(.hidden)').length;
        document.getElementById('normalTasks').textContent = document.querySelectorAll('.task-card[data-priority="normal"]:not(.hidden)').length;
    }

    function addTask(status) {
        window.location.href = `/tasks/create?status=${status}`;
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    // Get CSRF token
    function getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const columns = document.querySelectorAll('.column');
        const popup = document.getElementById('priority-popup');
        const closeBtn = document.getElementById('close-popup');

        // Initialize drag and drop for each column
        columns.forEach(function(column) {
            const sortable = new Sortable(column, {
                group: 'kanban',
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'task-card-chosen',
                dragClass: 'task-card-drag',
                filter: '.add-task-btn, .column-header, .text-muted, .task-actions',
                preventOnFilter: false,
                
                onStart: function(evt) {
                    console.log('Drag started');
                    evt.item.classList.add('dragging');
                },
                
                onEnd: function(evt) {
                    console.log('Drag ended');
                    evt.item.classList.remove('dragging');
                    
                    const item = evt.item;
                    const newColumn = evt.to;
                    const taskId = item.dataset.taskId;
                    
                    // Get new status from column data attribute
                    const newStatus = newColumn.dataset.status;
                    
                    console.log('Task ID:', taskId, 'New Status:', newStatus);
                    
                    if (!taskId) {
                        showNotification('Task ID tidak ditemukan.', 'error');
                        return;
                    }
                    
                    if (!newStatus) {
                        showNotification('Status kolom tidak valid.', 'error');
                        return;
                    }

                    // Show loading state
                    item.style.opacity = '0.6';
                    item.style.pointerEvents = 'none';
                    
                    // Get CSRF token
                    const csrfToken = getCSRFToken();
                    if (!csrfToken) {
                        showNotification('CSRF token tidak ditemukan.', 'error');
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        return;
                    }

                    // Send update request
                    fetch(`/tasks/${taskId}/update-status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        }),
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        
                        if (data.success) {
                            showNotification('Task berhasil dipindahkan!', 'success');
                            updateStats();
                            // Optional: reload page after short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showNotification(data.message || 'Gagal memperbarui status task.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        showNotification('Terjadi kesalahan saat memperbarui status.', 'error');
                    });
                }
            });
        });

        // Priority popup handling
        if (popup && closeBtn) {
            closeBtn.addEventListener('click', () => popup.remove());
            document.addEventListener('click', function(e) {
                if (!popup.contains(e.target) && !e.target.closest('#priority-popup')) {
                    popup.remove();
                }
            });
        }

        // Initialize stats
        updateStats();

        // Request notification permission
        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }
    });

    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Mobile menu toggle
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
            });
        }

        // User dropdown toggle
        if (userDropdown && dropdownMenu) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.parentElement.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                userDropdown.parentElement.classList.remove('active');
            });
        }
    });

    // Inject slideIn animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .task-card-chosen {
            opacity: 0.8;
        }
        .task-card-drag {
            transform: rotate(5deg);
        }
    `;
    document.head.appendChild(style);

    document.getElementById('prioritySuggestionBtn').addEventListener('click', function() {
  const popup = document.getElementById('priorityPopup');
  popup.classList.toggle('hidden');
});
</script>

@endsection
