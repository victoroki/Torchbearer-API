<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Torchbearer Institute of Technologies</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #FFF7D7 0%, #ECDFCE 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23CEB699' fill-opacity='0.2'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: drift 20s ease-in-out infinite;
        }
        
        @keyframes drift {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(30px, -30px); }
            66% { transform: translate(-20px, 20px); }
        }
        
        .admin-container {
            background: rgba(255, 247, 215, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(206, 182, 153, 0.3);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 50px -12px rgba(206, 182, 153, 0.3);
            position: relative;
            z-index: 1;
            animation: slideUp 0.8s ease-out;
            text-align: center;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .institute-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #D97706, #B45309);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            position: relative;
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.3);
        }
        
        .logo-circle::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D97706, #B45309, #92400E);
            z-index: -1;
            animation: pulse 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.05); opacity: 1; }
        }
        
        .torch-icon {
            width: 40px;
            height: 40px;
            fill: white;
        }
        
        .institute-name {
            color: #92400E;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #D97706, #92400E);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .admin-subtitle {
            color: #A16207;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .admin-description {
            color: #CEB699;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        
        .status-message {
            background: rgba(236, 223, 206, 0.5);
            border: 1px solid rgba(206, 182, 153, 0.6);
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .status-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        
        .status-title {
            color: #92400E;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .status-description {
            color: #A16207;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 24px;
        }
        
        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #D97706, #B45309);
            color: white;
        }
        
        .btn-secondary {
            background: rgba(236, 223, 206, 0.8);
            color: #92400E;
            border: 1px solid rgba(206, 182, 153, 0.6);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.3);
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .footer-info {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(206, 182, 153, 0.4);
            color: #A16207;
            font-size: 12px;
        }
        
        @media (max-width: 640px) {
            .admin-container {
                margin: 16px;
                padding: 32px 24px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="institute-logo">
            <div class="logo-circle">
                <img width="40px" src="{{ asset('torchbearer-logo.png') }}" alt="Torchbearer Logo" />
            </div>
            <h1 class="institute-name">Torchbearer Institute</h1>
            <p class="admin-subtitle">Administrative Portal</p>
            <p class="admin-description">Access the management dashboard to oversee institutional operations, student records, and academic programs.</p>
        </div>

        <!-- Authentication Status Display -->
        <div id="authStatus">
            @auth
                <!-- User is logged in -->
                <div class="status-message">
                    <div class="status-icon">🎉</div>
                    <h3 class="status-title">Welcome Back!</h3>
                    <p class="status-description">
                        You are already logged in as <strong>{{ Auth::user()->name ?? Auth::user()->username }}</strong>. 
                        Redirecting you to the dashboard...
                    </p>
                </div>
                <div class="action-buttons">
                    <button id="redirectBtn" class="btn btn-primary">
                        <span class="loading-spinner"></span>
                        Redirecting to Dashboard...
                    </button>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout Instead
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                <!-- User is not logged in -->
                <div class="status-message">
                    <div class="status-icon">🔒</div>
                    <h3 class="status-title">Authentication Required</h3>
                    <p class="status-description">
                        Please log in to access the administrative dashboard and manage institutional operations.
                    </p>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Proceed to Login
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        <i class="fas fa-home"></i>
                        Return to Homepage
                    </a>
                </div>
            @endauth
        </div>

        <div class="footer-info">
            <p>&copy; {{ date('Y') }} Torchbearer Institute of Technologies</p>
            <p>Secure Administrative Access</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @auth
                // User is logged in - redirect to home/dashboard after delay
                const redirectBtn = document.getElementById('redirectBtn');
                let countdown = 3;
                
                const updateButtonText = () => {
                    redirectBtn.innerHTML = `<span class="loading-spinner"></span> Redirecting in ${countdown}...`;
                    countdown--;
                    
                    if (countdown >= 0) {
                        setTimeout(updateButtonText, 1000);
                    } else {
                        window.location.href = "{{ route('home') }}";
                    }
                };
                
                // Start the countdown
                setTimeout(updateButtonText, 1000);
                
                // Allow manual redirect
                redirectBtn.addEventListener('click', function() {
                    window.location.href = "{{ route('home') }}";
                });
            @else
                // User is not logged in - animate the status message
                const statusMessage = document.querySelector('.status-message');
                const actionButtons = document.querySelector('.action-buttons');
                
                if (statusMessage && actionButtons) {
                    statusMessage.style.opacity = '0';
                    statusMessage.style.transform = 'translateY(20px)';
                    actionButtons.style.opacity = '0';
                    actionButtons.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        statusMessage.style.transition = 'all 0.6s ease';
                        statusMessage.style.opacity = '1';
                        statusMessage.style.transform = 'translateY(0)';
                    }, 300);
                    
                    setTimeout(() => {
                        actionButtons.style.transition = 'all 0.6s ease';
                        actionButtons.style.opacity = '1';
                        actionButtons.style.transform = 'translateY(0)';
                    }, 600);
                }
            @endauth
        });

        // Add Font Awesome for icons
        const faLink = document.createElement('link');
        faLink.rel = 'stylesheet';
        faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
        document.head.appendChild(faLink);
    </script>
</body>
</html>