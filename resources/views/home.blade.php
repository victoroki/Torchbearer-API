@extends('layouts.app')


@section('title', 'Dashboard - Torchbearer Institute of Technologies')

@section('styles')
<style>
    :root {
        --primary-orange: #D97706;
        --cream-yellow: #FFF7D7;
        --sage-green: #CEB699;
        --warm-beige: #ECDFCE;
        --orange-light: #F59E0B;
        --orange-dark: #B45309;
        --text-dark: #1F2937;
        --text-medium: #4B5563;
        --text-light: #6B7280;
        --shadow-soft: 0 4px 15px rgba(217, 119, 6, 0.15);
        --shadow-medium: 0 8px 25px rgba(217, 119, 6, 0.20);
        --shadow-strong: 0 12px 35px rgba(217, 119, 6, 0.25);
    }

    body {
        font-family: 'Figtree', sans-serif;
        background: linear-gradient(135deg, var(--cream-yellow) 0%, var(--warm-beige) 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .dashboard-card {
        background: linear-gradient(135deg, var(--cream-yellow) 0%, var(--warm-beige) 100%);
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-orange) 0%, var(--orange-light) 100%);
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }

    .stats-card {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-medium);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-strong);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stats-label {
        opacity: 0.95;
        font-weight: 500;
        margin-top: 0.5rem;
        font-size: 1rem;
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--sage-green) 0%, var(--warm-beige) 100%);
        border-radius: 20px;
        padding: 2.5rem;
        color: var(--text-dark);
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(217, 119, 6, 0.1);
        border-radius: 50%;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .welcome-subtitle {
        color: var(--text-medium);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .quick-action-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid var(--warm-beige);
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .quick-action-card:hover {
        border-color: var(--primary-orange);
        transform: translateY(-3px);
        box-shadow: var(--shadow-medium);
        text-decoration: none;
        color: inherit;
    }

    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 0;
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        transition: height 0.3s ease;
    }

    .quick-action-card:hover::before {
        height: 4px;
    }

    .quick-action-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--cream-yellow) 0%, var(--warm-beige) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: var(--primary-orange);
        transition: all 0.3s ease;
    }

    .quick-action-card:hover .quick-action-icon {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        color: white;
        transform: scale(1.1);
    }

    .quick-action-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .quick-action-desc {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .recent-activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        border-left: 5px solid var(--primary-orange);
    }

    .activity-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--warm-beige);
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: var(--cream-yellow);
        transform: translateX(5px);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--cream-yellow) 0%, var(--warm-beige) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: var(--primary-orange);
        font-size: 1.1rem;
    }

    .activity-content h6 {
        margin: 0;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .activity-content small {
        color: var(--text-light);
        font-size: 0.85rem;
    }

    .activity-time {
        margin-left: auto;
        color: var(--text-light);
        font-size: 0.8rem;
        font-weight: 500;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide {
        animation: slideInUp 0.6s ease-out;
    }

    .animate-slide:nth-child(2) {
        animation-delay: 0.1s;
    }

    .animate-slide:nth-child(3) {
        animation-delay: 0.2s;
    }

    .animate-slide:nth-child(4) {
        animation-delay: 0.3s;
    }

    .animate-slide:nth-child(5) {
        animation-delay: 0.4s;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-soft);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--orange-dark) 0%, var(--primary-orange) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }
</style>
@endsection

@section('content')
@auth
<div class="container">
    <!-- Welcome Section -->
    <div class="row">
        <div class="col-12 animate-slide">
            <div class="welcome-card mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">Welcome back, {{ Auth::user()->name ?? 'Admin' }}! 👋</h1>
                        <p class="welcome-subtitle">Here's what's happening with your training platform today.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <a href="{{ route('courses.create') }}" class="btn btn-primary-custom">
                            Quick Add
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6 animate-slide">
            <div class="stats-card mb-4">
                <h3 class="stats-number">{{ \App\Models\User::count() }}</h3>
                <p class="stats-label">Total Users</p>
                <div class="mt-2">
                    <small class="text-light">
                        {{ \App\Models\User::where('created_at', '>=', now()->subMonth())->count() }} new this month
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6 animate-slide">
            <div class="stats-card mb-4" style="background: linear-gradient(135deg, var(--sage-green) 0%, #9CA986 100%);">
                <h3 class="stats-number">{{ \App\Models\Event::where('date', '>=', now())->count() }}</h3>
                <p class="stats-label">Active Events</p>
                <div class="mt-2">
                    <small class="text-light">
                        {{ \App\Models\Event::where('created_at', '>=', now()->subWeek())->count() }} new this week
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6 animate-slide">
            <div class="stats-card mb-4" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                <h3 class="stats-number">{{ \App\Models\Certificate::count() }}</h3>
                <p class="stats-label">Certificates Issued</p>
                <div class="mt-2">
                    <small class="text-light">
                        {{ \App\Models\Certificate::where('created_at', '>=', now()->subWeek())->count() }} this week
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6 animate-slide">
            <div class="stats-card mb-4" style="background: linear-gradient(135deg, #B45309 0%, #92400E 100%);">
                <h3 class="stats-number">{{ \App\Models\TrainingProgram::count() }}</h3>
                <p class="stats-label">Training Programs</p>
                <div class="mt-2">
                    <small class="text-light">
                        {{ \App\Models\TrainingProgram::where('created_at', '>=', now()->subMonth())->count() }} new programs
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Recent Activity -->
    <div class="row">
        <div class="col-lg-8 animate-slide">
            <div class="card dashboard-card mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, var(--cream-yellow) 0%, var(--warm-beige) 100%); border: none;">
                    <h5 class="mb-0" style="color: var(--text-dark); font-weight: 600;">
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('courses.create') }}" class="quick-action-card">
                                <div class="quick-action-icon">+</div>
                                <h6 class="quick-action-title">New Course</h6>
                                <p class="quick-action-desc">Create a new training course</p>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('events.create') }}" class="quick-action-card">
                                <div class="quick-action-icon">📅</div>
                                <h6 class="quick-action-title">Add Event</h6>
                                <p class="quick-action-desc">Schedule new event</p>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('trainers.create') }}" class="quick-action-card">
                                <div class="quick-action-icon">👨‍🏫</div>
                                <h6 class="quick-action-title">Add Trainer</h6>
                                <p class="quick-action-desc">Register new trainer</p>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('resources.create') }}" class="quick-action-card">
                                <div class="quick-action-icon">⬆</div>
                                <h6 class="quick-action-title">Upload Resource</h6>
                                <p class="quick-action-desc">Add training materials</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 animate-slide">
            <div class="card recent-activity-card mb-4">
                <div class="card-header" style="background: var(--cream-yellow); border: none;">
                    <h5 class="mb-0" style="color: var(--text-dark); font-weight: 600;">
                        Recent Activity
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                    @foreach ($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            {{ $activity['icon'] ?? '📝' }}
                        </div>
                        <div class="activity-content">
                            <h6>{{ $activity['title'] ?? 'Activity' }}</h6>
                            <small>{{ $activity['description'] ?? 'No description' }}</small>
                        </div>
                        <span class="activity-time">{{ \Carbon\Carbon::createFromTimestamp($activity['created_at'])->diffForHumans() ?? 'Recently' }}</span>
                    </div>
                    @endforeach
                    @else
                    <div class="activity-item">
                        <div class="activity-icon">📝</div>
                        <div class="activity-content">
                            <h6>No recent activity</h6>
                            <small>Activities will appear here</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row">
        <div class="col-lg-4 animate-slide">
            <div class="card dashboard-card">
                <div class="card-header" style="background: linear-gradient(135deg, var(--sage-green) 0%, var(--warm-beige) 100%); border: none;">
                    <h5 class="mb-0" style="color: var(--text-dark); font-weight: 600;">
                        System Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: var(--text-medium);">Database</span>
                        <span class="badge" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                            Online
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: var(--text-medium);">Email Service</span>
                        <span class="badge" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                            Active
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="color: var(--text-medium);">Storage</span>
                        <span class="badge" style="background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%); color: white;">
                            78% Used
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="color: var(--text-medium);">Backup</span>
                        <span class="badge" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                            Updated
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<script>
    window.location.href = "{{ route('login') }}";
</script>
@endauth
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats numbers
        const statsNumbers = document.querySelectorAll('.stats-number');
        statsNumbers.forEach(function(stat) {
            const finalNumber = parseInt(stat.textContent.replace(',', ''));
            const duration = 2000;
            const increment = finalNumber / (duration / 50);
            let currentNumber = 0;

            const timer = setInterval(function() {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    stat.textContent = finalNumber.toLocaleString();
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.floor(currentNumber).toLocaleString();
                }
            }, 50);
        });
    });
</script>
@endsection