<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e0f7fa, #f1f8e9);
            padding: 10px;
        }

        .login-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 1.2rem;
            color: #333;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            color: #333;
            background: #f9f9f9;
            box-shadow: inset 2px 2px 6px #dcdcdc, inset -2px -2px 6px #fff;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            background: #fff;
            box-shadow: 0 0 8px rgba(79,172,254,0.7);
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
            border: none;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79,172,254,0.3);
        }

        .login-container button:hover {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
        }

        .error-box {
            margin-top: 1rem;
            background: #ffe5e5;
            padding: 12px;
            border-radius: 8px;
            color: #e74c3c;
            font-size: 14px;
            font-weight: 500;
        }

        .try-again {
            margin-top: 10px;
            display: inline-block;
            text-decoration: none;
            font-size: 14px;
            color: #0072ff;
            font-weight: bold;
            cursor: pointer;
        }

        .try-again:hover {
            text-decoration: underline;
        }

        /* Hide form when error is shown */
        .hidden {
            display: none;
        }

        /* 🔹 Responsive styles */
        @media (max-width: 600px) {
            .login-container {
                padding: 1.5rem;
                border-radius: 10px;
            }
            .login-container h2 {
                font-size: 1.3rem;
            }
            .form-group input {
                font-size: 14px;
                padding: 10px 12px;
            }
            .login-container button {
                font-size: 15px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        {{-- Error box --}}
        @if ($errors->any())
            <div class="error-box" id="errorBox">
                <p>{{ $errors->first() }}</p>
                <span class="try-again" onclick="showForm()">🔄 Try Again</span>
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/login') }}" id="loginForm" 
              class="@if($errors->any()) hidden @endif">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        function showForm() {
            document.getElementById('errorBox').style.display = 'none';
            document.getElementById('loginForm').classList.remove('hidden');
            document.querySelector('#loginForm input[name="email"]').focus();
        }
    </script>
</body>
</html>
