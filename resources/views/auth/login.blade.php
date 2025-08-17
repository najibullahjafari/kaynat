<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPS Company Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron:wght@700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #202359;
            --primary-dark: #202359;
            --primary-light: #2a4da8;
            --secondary-color: #43cad9;
            --secondary-dark: #32adbb;
            --secondary-light: #47d9e9;
            --accent-color: #00a8e8;
            --dark-color: #212529;
            --gray-dark: #495057;
            --gray-medium: #6c757d;
            --gray-light: #e9ecef;
            --light-color: #f8f9fa;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --font-primary: 'Montserrat', sans-serif;
            --font-secondary: 'Orbitron', sans-serif;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.2);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-primary);
        }

        .login-container {
            background: var(--light-color);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-lg);
            padding: 2.5rem 2rem 2rem 2rem;
            width: 100%;
            max-width: 400px;
            margin: 2rem;
            position: relative;
        }

        .login-title {
            font-family: var(--font-secondary);
            color: var(--primary-color);
            font-size: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }

        .login-form label {
            font-weight: 600;
            color: var(--gray-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 90%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-light);
            border-radius: 0.75rem;
            background: var(--light-color);
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .login-form input[type="email"]:focus,
        .login-form input[type="password"]:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 0 2px var(--secondary-light);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            accent-color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .forgot-link {
            color: var(--primary-light);
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--accent-color);
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            font-family: var(--font-secondary);
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 0;
            margin-top: 0.5rem;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            letter-spacing: 1px;
            transition: var(--transition);
        }

        .login-btn:hover {
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
            box-shadow: 0 6px 18px rgba(67, 202, 217, 0.15);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .status-message {
            color: var(--success-color);
            font-size: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        @media (max-width: 500px) {
            .login-container {
                /* padding: 1.5rem 0.5rem; */
                margin: 0;
            }

        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-title">Kaynat Login</div>
        @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
        @endif
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username">
            @if ($errors->has('email'))
            <div class="error-message">{{ $errors->first('email') }}</div>
            @endif

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @if ($errors->has('password'))
            <div class="error-message">{{ $errors->first('password') }}</div>
            @endif

            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me" style="margin-bottom:0;">Remember me</label>
            </div>

            {{-- <div style="display: flex; justify-content: space-between; align-items: center;">
                @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
            </div> --}}

            <button class="login-btn" type="submit">Log in</button>
        </form>
    </div>
</body>

</html>