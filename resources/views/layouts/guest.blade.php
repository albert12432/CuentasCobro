<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'CuentasCobro')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --apple-blue: #0071e3;
            --apple-dark: #1d1d1f;
            --apple-gray: #86868b;
            --apple-light-gray: #f5f5f7;
            --apple-white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 480px;
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: saturate(180%) blur(20px);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .login-logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .login-logo-icon .material-symbols-rounded {
            font-size: 48px;
            color: white;
        }
        
        .login-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--apple-dark);
            margin-bottom: 8px;
        }
        
        .login-subtitle {
            font-size: 16px;
            color: var(--apple-gray);
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--apple-dark);
            margin-bottom: 8px;
        }
        
        .form-label .material-symbols-rounded {
            font-size: 20px;
            color: var(--apple-gray);
        }
        
        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 16px;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            font-family: inherit;
            background: white;
        }
        
        .form-input:focus {
            border-color: var(--apple-blue);
            box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
        }
        
        .form-input.is-invalid {
            border-color: #ff3b30;
        }
        
        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(255, 59, 48, 0.1);
        }
        
        .invalid-feedback {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #ff3b30;
            margin-top: 6px;
        }
        
        .invalid-feedback .material-symbols-rounded {
            font-size: 16px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #e5e5e5;
            border-radius: 6px;
            cursor: pointer;
            accent-color: var(--apple-blue);
        }
        
        .form-check-label {
            font-size: 14px;
            color: var(--apple-dark);
            cursor: pointer;
            user-select: none;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            font-size: 17px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login .material-symbols-rounded {
            font-size: 22px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e5e5;
        }
        
        .login-footer-text {
            font-size: 14px;
            color: var(--apple-gray);
        }
        
        .login-footer-link {
            color: var(--apple-blue);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }
        
        .login-footer-link:hover {
            opacity: 0.8;
        }
        
        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: start;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-danger {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
        }
        
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        
        .alert .material-symbols-rounded {
            font-size: 22px;
            flex-shrink: 0;
        }
        
        .alert-content {
            flex: 1;
        }
        
        .alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .alert li {
            margin: 4px 0;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .login-title {
                font-size: 28px;
            }
            
            .login-subtitle {
                font-size: 14px;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #1e3a8a 0%, #581c87 100%);
            }
        }
    </style>
</head>
<body>
    @yield('content')
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
