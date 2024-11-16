<?php 
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['loginEmail']);
    $password = trim($_POST['loginPassword']);

    try {
        // Adatbázis lekérdezés
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['success'] = "Sikeresen bejelentkeztél!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Helytelen email vagy jelszó!";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Rendszerhiba történt: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #00008b 0%, #323232 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #004b93;
        }
        .btn-custom {
            background: linear-gradient(45deg, orange, #FF4500);
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #FF4500, orange);
        }
        .form-control:focus {
            border-color: #004b93;
            box-shadow: 0 0 0 0.2rem rgba(0, 75, 147, 0.25);
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Bejelentkezés</h2>

        <!-- PHP SESSION üzenetek -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="">
            <!-- Email mező -->
            <div class="mb-3">
                <label for="loginEmail" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="loginEmail" name="loginEmail" required>
            </div>

            <!-- Jelszó mező -->
            <div class="mb-3 position-relative">
                <label for="loginPassword" class="form-label">Jelszó</label>
                <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                <i class="toggle-password" onclick="togglePassword()">👁️</i>
            </div>

            <!-- Checkbox és gombok -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Emlékezz rám</label>
            </div>

            <button type="submit" class="btn btn-custom w-100" name="login">Bejelentkezés</button>
        </form>

        <!-- Extra funkciók -->
        <div class="text-center mt-3">
            <a href="#" class="text-muted">Elfelejtetted a jelszavad?</a><br>
            <a href="register.php" class="text-muted">Nincs még fiókod? Regisztrálj!</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Saját JS -->
    <script>
// Jelszó megjelenítése/elrejtése
function togglePassword() {
    const passwordInput = document.getElementById('loginPassword');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}

// Form validáció
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    if (email.trim() === '' || password.trim() === '') {
        alert('Kérjük, töltsd ki az összes mezőt!');
        event.preventDefault();
    } else if (!validateEmail(email)) {
        alert('Érvénytelen email cím!');
        event.preventDefault();
    }
});

// Email validálás
function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(String(email).toLowerCase());
}
</script>
</body>
</html>
