<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furni. - Admin & Petugas Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            /* slightly gray to make login box pop */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #3b5d50;
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            box-sizing: border-box;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 50;
        }

        .furni-logo {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.05em;
        }

        .admin-badge {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            letter-spacing: 0.05em;
        }

        .form-section {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 40px;
            box-sizing: border-box;
            border: 1px solid #f1f5f9;
        }

        .login-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 30px;
            color: #1e293b;
        }

        .admin-input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            color: #334155;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background-color: #f8fafc;
        }

        .admin-input::placeholder {
            color: #94a3b8;
        }

        .admin-input:focus {
            outline: none;
            border-color: #3b5d50;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 93, 80, 0.1);
        }

        .admin-btn {
            width: 100%;
            background-color: #3b5d50;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: opacity 0.2s;
            margin-top: 10px;
            font-family: 'Inter', sans-serif;
        }

        .admin-btn:hover {
            opacity: 0.92;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
            font-size: 13px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2 class="furni-logo">Furni.</h2>
    </nav>

    <div class="form-section">
        <div class="form-container">
            <h2 class="login-title">Login</h2>

            @if ($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf
                <div>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="admin-input" placeholder="Username">
                </div>

                <div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="admin-input" placeholder="Password">
                </div>

                <div>
                    <button type="submit" class="admin-btn">
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        <!-- Adding empty space for scrolling flexibility -->
        <div style="height: 80px;"></div>
    </div>

</body>

</html>