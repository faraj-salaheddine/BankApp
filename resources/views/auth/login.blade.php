<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0049b7, #00a8ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            background: #ffffff;
            width: 900px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .left-side {
            background: linear-gradient(135deg, #0049b7, #00a8ff);
            width: 50%;
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
        }

        /* Logo en haut à gauche */
        .logo-container {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 70px;
            height: auto;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        .content-section {
            width: 100%;
            margin-top: 40px;
        }

        .left-side h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .left-side p {
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 40px;
            opacity: 0.95;
        }

        .view-more-btn {
            padding: 12px 25px;
            border-radius: 30px;
            border: none;
            background: white;
            color: #0049b7;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .view-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .right-side {
            width: 50%;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side h2 {
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: #333;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: #999;
            opacity: 1;
        }

        .input-group input:focus {
            outline: none;
            border-color: #0049b7;
            box-shadow: 0 0 5px rgba(0, 73, 183, 0.2);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(135deg, #0049b7, #00a8ff);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 73, 183, 0.3);
        }

        .small-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .small-text a {
            color: #0049b7;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .small-text a:hover {
            text-decoration: underline;
        }

        .error {
            color: #d32f2f;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background: #ffebee;
            border-radius: 5px;
            border-left: 4px solid #d32f2f;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 95%;
                max-width: 500px;
            }

            .left-side, .right-side {
                width: 100%;
            }

            .left-side {
                padding: 40px 30px;
                justify-content: flex-start;
            }

            .right-side {
                padding: 40px 30px;
            }

            .left-side h1 {
                font-size: 32px;
            }

            .right-side h2 {
                font-size: 24px;
            }

            .logo-container img {
                width: 60px;
            }
        }
    </style>

</head>

<body>

<div class="container">

    <div class="left-side">
        <!-- Logo en haut à gauche -->
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="HIF Bank Logo">
        </div>

        <!-- Contenu principal -->
        <div class="content-section">
            <h1>Bienvenue à HIF Bank !</h1>
            <p>HIF Bank – Accédez à votre espace d’administration</p>
            <button class="view-more-btn">View more</button>
        </div>
    </div>

    <div class="right-side">
        <h2>Sign in</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="input-group">
                <input type="email" name="email" placeholder="Email address" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="login-btn" type="submit">Login</button>
        </form>

        <p class="small-text">
            Not a member yet? <a href="#">Sign up</a>
        </p>
    </div>
</div>

</body>
</html>