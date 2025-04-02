<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Lifeats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ff691c, #ff9d57);
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: #fff;
            padding: 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-card h2 {
            font-weight: 700;
            color: #ff691c;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            text-align: left;
            display: block;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #ff691c;
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #e85d17;
        }

        .message {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: red;
        }

        .tagline {
            font-size: 1rem;
            color: #555;
            margin-bottom: 1rem;
        }

        .tagline strong {
            color: #ff691c;
        }

        .register-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            font-size: 0.95rem;
            color: #ff691c;
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 600;
        }

        .register-link:hover {
            color: #e85d17;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2>Welcome Back 👋</h2>
        <p class="tagline">Fuel your day with <strong>healthy vibes</strong></p>
        <form id="loginForm">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" required placeholder="you@lifeats.com">

            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" required placeholder="•••••••••••">

            <button type="submit">Let's Go →</button>
            <a href="register.php" class="register-link">I don’t have an account</a>
            <div class="message" id="message"></div>
        </form>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const messageDiv = document.getElementById('message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    setCookie('token', data.token);
                    setCookie('user', JSON.stringify(data.user));

                    messageDiv.style.color = 'green';
                    messageDiv.textContent = 'Welcome to Lifeats! Redirecting...';

                    setTimeout(() => {
                        window.location.href = 'profile.php';
                    }, 1500);
                } else {
                    messageDiv.textContent = data.message || 'Login failed';
                }
            } catch (error) {
                messageDiv.textContent = 'Server error. Please try again later.';
                console.error(error);
            }
        });

        function setCookie(name, value, days = 1) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }
    </script>
</body>

</html>