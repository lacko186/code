<?php
session_start();
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['registerUsername']);
    $email = trim($_POST['registerEmail']);
    $password = $_POST['registerPassword'];
    $password_confirm = $_POST['registerPasswordConfirm'];
    
    $errors = [];

    // Enhanced validations
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $errors[] = "Minden mező kitöltése kötelező!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Érvénytelen email cím formátum!";
    }

    if (strlen($password) < 8) {
        $errors[] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
    }

    if ($password !== $password_confirm) {
        $errors[] = "A jelszavak nem egyeznek!";
    }

    if (empty($errors)) {
        try {
            // Check if email already exists
            $check_sql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([':email' => $email]);
            
            if ($check_stmt->fetchColumn() > 0) {
                $errors[] = "Ez az email cím már regisztrálva van!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
                $stmt = $conn->prepare($sql);
                
                $result = $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashed_password
                ]);
                
                if ($result) {
                    $_SESSION['success'] = "Sikeres regisztráció! Kérjük, jelentkezzen be.";
                    header("Location: login.php");
                    exit();
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Rendszerhiba történt. Kérjük, próbálja újra később.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KK Zrt. - Regisztráció</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #ff6f00;
            --accent-color: #ffd54f;
            --error-color: #d32f2f;
            --success-color: #388e3c;
            --background-gradient: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .welcome-banner {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem;
            text-align: center;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container svg {
            width: 80px;
            height: 80px;
            fill: var(--primary-color);
            margin-bottom: 1rem;
        }

        .company-name {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
            outline: none;
        }

        .form-group i {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: #757575;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.2);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: var(--secondary-color);
        }

        .error-message {
            background: rgba(211, 47, 47, 0.1);
            color: var(--error-color);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 1.5rem;
            }

            .company-name {
                font-size: 1.2rem;
            }
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 1.5rem;
            border-radius: 15px;
            color: white;
            text-align: center;
        }

        .feature-item i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="welcome-banner">
        <h2>Üdvözöljük a Kaposvári Közlekedési Zrt. online felületén!</h2>
    </div>

    <div class="container">
        <div class="register-card">
            <div class="logo-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M488 128h-8V80c0-44.8-99.2-80-224-80S32 35.2 32 80v48h-8c-13.3 0-24 10.7-24 24v80c0 13.3 10.8 24 24 24h8v160c0 17.7 14.3 32 32 32v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32v-32h192v32c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32v-32h6.4c16 0 25.6-12.8 25.6-25.6V256h8c13.3 0 24-10.8 24-24v-80c0-13.3-10.8-24-24-24zM112 400c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm16-112c-17.7 0-32-14.3-32-32V128c0-17.7 14.3-32 32-32h256c17.7 0 32 14.3 32 32v128c0 17.7-14.3 32-32 32H128zm272 112c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"/>
                </svg>
                <h1 class="company-name">Kaposvári Közlekedési Zrt.</h1>
                <p>Regisztráció</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="registerUsername">Felhasználónév</label>
                    <input type="text" id="registerUsername" name="registerUsername" value="<?php echo isset($_POST['registerUsername']) ? htmlspecialchars($_POST['registerUsername']) : ''; ?>" required>
                    <i class="fas fa-user"></i>
                </div>

                <div class="form-group">
                    <label for="registerEmail">Email cím</label>
                    <input type="email" id="registerEmail" name="registerEmail" value="<?php echo isset($_POST['registerEmail']) ? htmlspecialchars($_POST['registerEmail']) : ''; ?>" required>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="form-group">
                    <label for="registerPassword">Jelszó</label>
                    <input type="password" id="registerPassword" name="registerPassword" required>
                    <i class="fas fa-lock"></i>
                </div>

                <div class="form-group">
                    <label for="registerPasswordConfirm">Jelszó megerősítése</label>
                    <input type="password" id="registerPasswordConfirm" name="registerPasswordConfirm" required>
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" name="register" class="submit-btn">
                    <i class="fas fa-user-plus"></i> Regisztráció
                </button>
            </form>

            <div class="login-link">
                <p>Már van fiókja? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Bejelentkezés</a></p>
            </div>
        </div>

        <div class="feature-grid">
            <div class="feature-item">
                <i class="fas fa-bus"></i>
                <h3>Menetrend követés</h3>
                <p>Valós idejű járműkövetés és menetrend információk</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-ticket-alt"></i>
                <h3>Online jegyvásárlás</h3>
                <p>Kényelmes és gyors jegyvásárlás otthonról</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-bell"></i>
                <h3>Értesítések</h3>
                <p>Azonnali értesítések járatváltozásokról</p>
            </div>
        </div>
    </div>

    <script>
        // Show/hide password functionality
        document.querySelectorAll('input[type="password"]').forEach(input => {
            const icon = input.nextElementSibling;
            icon.style.cursor = 'pointer';
            icon.addEventListener('click', () => {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.classList.toggle('fa-lock');
                icon.classList.toggle('fa-lock-open');
            });
        });
    </script>
</body>
</html>
