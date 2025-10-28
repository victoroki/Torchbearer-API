<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Torchbearer Institute of Technologies</title>
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
        }
        
        .login-form {
            margin-top: 32px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            color: #92400E;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(236, 223, 206, 0.5);
            border: 1px solid rgba(206, 182, 153, 0.6);
            border-radius: 12px;
            color: #92400E;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-input::placeholder {
            color: #CEB699;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #D97706;
            background: rgba(236, 223, 206, 0.8);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
            transform: translateY(-2px);
        }
        
        .form-input.is-invalid {
            border-color: #B45309;
        }
        
        .invalid-feedback {
            color: #B45309;
            font-size: 12px;
            margin-top: 8px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .form-check-input {
            margin-right: 8px;
        }
        
        .form-check-label {
            color: #92400E;
            font-size: 14px;
            font-weight: 500;
        }
        
        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #D97706, #B45309);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.4);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .login-button:hover::before {
            left: 100%;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 24px;
        }
        
        .forgot-password a {
            color: #D97706;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: #B45309;
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
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="institute-logo">
            <div class="logo-circle">
                <img width="70px" src="{{ asset('torchbearer-logo.png') }}" alt="Torchbearer Logo" />
            </div>
            <h1 class="institute-name">Torchbearer Institute</h1>
            <p class="admin-subtitle">Administrative Portal</p>
            <p class="admin-description">Access the management dashboard to oversee institutional operations, student records, and academic programs.</p>
        </div>

        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                <input 
                    type="email" 
                    id="email" 
                    class="form-input @error('email') is-invalid @enderror" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Enter your email address"
                    required 
                    autocomplete="email" 
                    autofocus
                >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                <input 
                    type="password" 
                    id="password" 
                    class="form-input @error('password') is-invalid @enderror" 
                    name="password" 
                    placeholder="Enter your password"
                    required 
                    autocomplete="current-password"
                >
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="remember" 
                    id="remember" 
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            
            <button type="submit" class="login-button">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                </div>
            @endif
        </form>

        <div class="footer-info">
            <p>&copy; {{ date('Y') }} Torchbearer Institute of Technologies</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-group, .form-check, .login-button, .forgot-password');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, (index + 1) * 100);
            });
        });
    </script>
</body>
</html>