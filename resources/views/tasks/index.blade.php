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
/* Priority Hint Button - Berkedip */
    .priority-hint-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }
    .priority-hint-btn {
        background: linear-gradient(45deg, #ffc107, #ff9800);
        color: #333;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: pulseGlow 2s ease-in-out infinite;
    }
    @keyframes pulseGlow {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }
        50% { 
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(255, 193, 7, 0.6);
        }
    }
    .priority-hint-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.5);
        animation: none;
    }
    .priority-hint-btn.clicked {
        animation: none;
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    /* Priority Hint Popup - Improved */
    .priority-hint-popup {
        position: absolute;
        top: 60px;
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        min-width: 320px;
        max-width: 400px;
        opacity: 0;
        transform: translateY(-20px);
        pointer-events: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .priority-hint-popup.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: all;
    }
    .popup-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .popup-title {
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .popup-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .popup-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }
    .popup-content {
        padding: 20px;
    }
    .popup-intro {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    .priority-tasks-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .priority-task-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px;
        border-left: 4px solid;
        transition: all 0.3s ease;
        cursor: pointer; /* ✅ Tambahkan cursor pointer */
    }
    .priority-task-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* ✅ Tambahkan shadow saat hover */
    }
    .priority-task-item.urgent {
        border-left-color: #dc3545;
    }
    .priority-task-item.high {
        border-left-color: #fd7e14;
    }
    .priority-task-item.normal {
        border-left-color: #28a745;
    }
    .task-item-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        font-size: 0.9rem;
    }
    .task-item-deadline {
        font-size: 0.8rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .task-item-priority {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 5px;
        padding: 2px 6px;
        border-radius: 10px;
        display: inline-block;
    }
    .task-item-priority.urgent {
        background: #dc3545;
        color: white;
    }
    .task-item-priority.high {
        background: #fd7e14;
        color: white;
    }
    .task-item-priority.normal {
        background: #28a745;
        color: white;
    }

    /* ✅ TAMBAHAN: Modal untuk detail task */
    .task-detail-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }
    .task-detail-modal.show {
        display: flex;
    }
    .task-detail-content {
        background: white;
        border-radius: 15px;
        padding: 25px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .task-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    .task-detail-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }
    .task-detail-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #888;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    .task-detail-close:hover {
        background: #f0f0f0;
        color: #333;
    }
    .task-detail-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .task-detail-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .task-detail-label {
        font-weight: 600;
        color: #555;
        min-width: 100px;
    }
    .task-detail-value {
        color: #333;
        flex: 1;
    }

    /* Responsive Design untuk Priority Hint */
    @media (max-width: 768px) {
        .priority-hint-container {
            top: 80px;
            right: 15px;
        }
        
        .priority-hint-btn {
            padding: 10px 16px;
            font-size: 0.8rem;
        }
        
        .priority-hint-popup {
            right: -10px;
            min-width: 280px;
            max-width: 90vw;
        }
        
        .popup-content {
            padding: 15px;
        }
    }
    @media (max-width: 480px) {
        .priority-hint-container {
            top: 70px;
            right: 10px;
        }
        
        .priority-hint-btn {
            padding: 8px 12px;
            font-size: 0.75rem;
        }
        
        .priority-hint-popup {
            right: -5px;
            min-width: 260px;
        }
    }
    
    
    
    
    
    
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
        position: relative; /* ✅ Untuk badge counter */
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

    /* ✅ TAMBAHAN: Badge counter untuk filter */
    .filter-counter {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #fff;
        color: #333;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        border: 2px solid currentColor;
    }
    .filter-btn.urgent .filter-counter {
        background: #fff;
        color: #ff4757;
        border-color: #ff4757;
    }
    .filter-btn.high .filter-counter {
        background: #fff;
        color: #ff6b35;
        border-color: #ff6b35;
    }
    .filter-btn.normal .filter-counter {
        background: #fff;
        color: #26a69a;
        border-color: #26a69a;
    }
    .filter-btn.all .filter-counter {
        background: #667eea;
        color: #fff;
        border-color: #667eea;
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
            <span class="filter-counter" id="allCounter">0</span>
        </button>
        <button class="filter-btn urgent" onclick="filterTasks('urgent')">
            🔴 Urgent
            <span class="filter-counter" id="urgentCounter">0</span>
        </button>
        <button class="filter-btn high" onclick="filterTasks('high')">
            🟠 High
            <span class="filter-counter" id="highCounter">0</span>
        </button>
        <button class="filter-btn normal" onclick="filterTasks('normal')">
            🟢 Normal
            <span class="filter-counter" id="normalCounter">0</span>
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

<!-- SARAN PRIORITAS POPUP -->
@if ($suggestedTasks->count())
<div class="priority-hint-container">
    <button class="priority-hint-btn" id="priorityHintBtn">
        <i class="fas fa-lightbulb"></i>
        <span>Saran Prioritas</span>
    </button>
    
    <div class="priority-hint-popup" id="priorityHintPopup">
        <div class="popup-header">
            <div class="popup-title">
                <i class="fas fa-brain"></i>
                <span>Saran Prioritas Tugas</span>
            </div>
            <button class="popup-close" id="closePopup">&times;</button>
        </div>
        
        <div class="popup-content">
            <div class="popup-intro">
                Berikut adalah tugas-tugas yang sebaiknya Anda prioritaskan berdasarkan deadline dan tingkat urgensi:
            </div>
            
            <div class="priority-tasks-list" id="priorityTasksList">
                @foreach ($suggestedTasks->take(3) as $task)
                <div class="priority-task-item {{ $task->priority }}" 
                     data-task-id="{{ $task->id }}"
                     data-task-title="{{ $task->title }}"
                     data-task-description="{{ $task->description }}"
                     data-task-deadline="{{ $task->deadline }}"
                     data-task-priority="{{ $task->priority }}"
                     data-task-category="{{ $task->category ?? 'Tidak ada kategori' }}"
                     data-task-status="{{ $task->status }}">
                    <div class="task-item-title">{{ $task->title }}</div>
                    <div class="task-item-deadline">
                        <i class="far fa-clock"></i>
                        <span>Deadline: {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</span>
                    </div>
                    <div class="task-item-priority {{ $task->priority }}">{{ ucfirst($task->priority) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- ✅ MODAL DETAIL TASK -->
<div class="task-detail-modal" id="taskDetailModal">
    <div class="task-detail-content">
        <div class="task-detail-header">
            <div class="task-detail-title" id="modalTaskTitle">Detail Tugas</div>
            <button class="task-detail-close" id="closeTaskModal">&times;</button>
        </div>
        <div class="task-detail-info">
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-heading"></i> Judul:
                </div>
                <div class="task-detail-value" id="modalTaskTitleValue">-</div>
            </div>
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-align-left"></i> Deskripsi:
                </div>
                <div class="task-detail-value" id="modalTaskDescription">-</div>
            </div>
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-calendar-alt"></i> Deadline:
                </div>
                <div class="task-detail-value" id="modalTaskDeadline">-</div>
            </div>
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-exclamation-circle"></i> Prioritas:
                </div>
                <div class="task-detail-value" id="modalTaskPriority">-</div>
            </div>
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-tag"></i> Kategori:
                </div>
                <div class="task-detail-value" id="modalTaskCategory">-</div>
            </div>
            <div class="task-detail-row">
                <div class="task-detail-label">
                    <i class="fas fa-info-circle"></i> Status:
                </div>
                <div class="task-detail-value" id="modalTaskStatus">-</div>
            </div>
        </div>
    </div>
</div>

<script>
    // ✅ PERBAIKAN: Global functions dengan counter yang benar
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
        updateFilterCounters(); // ✅ Update counter setelah filter
    }

    // ✅ PERBAIKAN: Fungsi update stats yang lebih akurat
    function updateStats() {
        const visibleTasks = document.querySelectorAll('.task-card:not(.hidden)');
        const urgentTasks = document.querySelectorAll('.task-card[data-priority="urgent"]:not(.hidden)');
        const highTasks = document.querySelectorAll('.task-card[data-priority="high"]:not(.hidden)');
        const normalTasks = document.querySelectorAll('.task-card[data-priority="normal"]:not(.hidden)');

        document.getElementById('totalTasks').textContent = visibleTasks.length;
        document.getElementById('urgentTasks').textContent = urgentTasks.length;
        document.getElementById('highTasks').textContent = highTasks.length;
        document.getElementById('normalTasks').textContent = normalTasks.length;
    }

    // ✅ BARU: Fungsi untuk update counter di filter button
    function updateFilterCounters() {
        const allTasks = document.querySelectorAll('.task-card');
        const urgentTasks = document.querySelectorAll('.task-card[data-priority="urgent"]');
        const highTasks = document.querySelectorAll('.task-card[data-priority="high"]');
        const normalTasks = document.querySelectorAll('.task-card[data-priority="normal"]');

        // Update counter di setiap filter button
        const allCounter = document.getElementById('allCounter');
        const urgentCounter = document.getElementById('urgentCounter');
        const highCounter = document.getElementById('highCounter');
        const normalCounter = document.getElementById('normalCounter');

        if (allCounter) allCounter.textContent = allTasks.length;
        if (urgentCounter) urgentCounter.textContent = urgentTasks.length;
        if (highCounter) highCounter.textContent = highTasks.length;
        if (normalCounter) normalCounter.textContent = normalTasks.length;
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

    // ✅ BARU: Fungsi untuk menampilkan detail task
    function showTaskDetail(taskData) {
        const modal = document.getElementById('taskDetailModal');
        
        // Populate modal dengan data task
        document.getElementById('modalTaskTitleValue').textContent = taskData.title;
        document.getElementById('modalTaskDescription').textContent = taskData.description;
        document.getElementById('modalTaskDeadline').textContent = formatDeadline(taskData.deadline);
        document.getElementById('modalTaskPriority').innerHTML = `<span class="priority-badge ${taskData.priority}">${taskData.priority.toUpperCase()}</span>`;
        document.getElementById('modalTaskCategory').textContent = taskData.category;
        document.getElementById('modalTaskStatus').textContent = formatStatus(taskData.status);
        
        // Show modal
        modal.classList.add('show');
    }

    // ✅ BARU: Helper functions untuk format data
    function formatDeadline(deadline) {
        const date = new Date(deadline);
        const now = new Date();
        const diffTime = date - now;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays < 0) {
            return `${Math.abs(diffDays)} hari yang lalu (TERLAMBAT)`;
        } else if (diffDays === 0) {
            return 'Hari ini';
        } else if (diffDays === 1) {
            return 'Besok';
        } else {
            return `${diffDays} hari lagi`;
        }
    }

    function formatStatus(status) {
        const statusMap = {
            'todo': 'Belum Dikerjakan',
            'in_progress': 'Sedang Dikerjakan',
            'done': 'Selesai'
        };
        return statusMap[status] || status;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const columns = document.querySelectorAll('.column');
        
        // ===== Drag & Drop =====
        columns.forEach(function(column) {
            const sortable = new Sortable(column, {
                group: 'kanban',
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'task-card-chosen',
                dragClass: 'task-card-drag',
                filter: '.add-task-btn, .column-header, .text-muted, .task-actions',
                preventOnFilter: false,
                onStart(evt) {
                    evt.item.classList.add('dragging');
                },
                onEnd(evt) {
                    const item = evt.item;
                    const newColumn = evt.to;
                    const taskId = item.dataset.taskId;
                    const newStatus = newColumn.dataset.status;

                    if (!taskId || !newStatus) return;

                    item.style.opacity = '0.6';
                    item.style.pointerEvents = 'none';

                    fetch(`/tasks/${taskId}/update-status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ status: newStatus })
                    }).then(res => res.json())
                    .then(data => {
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                        if (data.success) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    }).catch(() => {
                        item.style.opacity = '1';
                        item.style.pointerEvents = 'auto';
                    });
                }
            });
        });

        // ===== Priority Hint Popup Handling =====
        const hintBtn = document.getElementById('priorityHintBtn');
        const popup = document.getElementById('priorityHintPopup');
        const closeBtn = document.getElementById('closePopup');
        let isPopupOpen = false;

        if (hintBtn && popup) {
            // Toggle popup
            hintBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                if (!isPopupOpen) {
                    popup.classList.add('show');
                    hintBtn.classList.add('clicked');
                    isPopupOpen = true;
                } else {
                    popup.classList.remove('show');
                    hintBtn.classList.remove('clicked');
                    isPopupOpen = false;
                }
            });

            // Close popup
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    popup.classList.remove('show');
                    hintBtn.classList.remove('clicked');
                    isPopupOpen = false;
                });
            }

            // Close popup when clicking outside
            document.addEventListener('click', function(e) {
                if (!popup.contains(e.target) && e.target !== hintBtn) {
                    popup.classList.remove('show');
                    hintBtn.classList.remove('clicked');
                    isPopupOpen = false;
                }
            });

            // Stop blinking animation after first click
            hintBtn.addEventListener('click', function() {
                setTimeout(() => {
                    hintBtn.style.animation = 'none';
                }, 3000);
            });
        }

        // ✅ BARU: Event listener untuk klik pada priority task items
        const priorityTaskItems = document.querySelectorAll('.priority-task-item');
        priorityTaskItems.forEach(item => {
            item.addEventListener('click', function() {
                const taskData = {
                    id: this.dataset.taskId,
                    title: this.dataset.taskTitle,
                    description: this.dataset.taskDescription,
                    deadline: this.dataset.taskDeadline,
                    priority: this.dataset.taskPriority,
                    category: this.dataset.taskCategory,
                    status: this.dataset.taskStatus
                };
                
                showTaskDetail(taskData);
                
                // Close priority popup
                popup.classList.remove('show');
                hintBtn.classList.remove('clicked');
                isPopupOpen = false;
            });
        });

        // ✅ BARU: Modal close handlers
        const taskModal = document.getElementById('taskDetailModal');
        const closeTaskModal = document.getElementById('closeTaskModal');

        if (closeTaskModal) {
            closeTaskModal.addEventListener('click', function() {
                taskModal.classList.remove('show');
            });
        }

        // Close modal when clicking outside
        if (taskModal) {
            taskModal.addEventListener('click', function(e) {
                if (e.target === taskModal) {
                    taskModal.classList.remove('show');
                }
            });
        }

        // ✅ Initialize stats and counters
        updateStats();
        updateFilterCounters();

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
</script>

@endsection
