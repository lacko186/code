:root {
    --volan-blue: #004b93;
    --volan-yellow: #ffd800;
    --volan-orange: #FF7F50;
    --volan-purple: #8A2BE2;
    --volan-green: #32CD32;
}

body {
    background: linear-gradient(135deg, #000000, #8B0000, #4B0082);
    background-size: 300% 300%;
    animation: gradientShift 10s infinite ease-in-out;
    min-height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: Arial, sans-serif;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.register-container {
    width: 90%;
    max-width: 1200px;
    min-width: 300px;
    padding: 2.5rem;
    background: linear-gradient(135deg, #FFFFFF, #F0F0F0);
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    animation: fadeIn 1.2s ease-out;
}

.icon-container {
    text-align: center;
    margin-bottom: 2rem;
    animation: bounceIn 1.2s ease-out;
}

.icon-container i {
    font-size: 4rem;
    background: linear-gradient(90deg, var(--volan-blue), var(--volan-purple), var(--volan-yellow));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

form div {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

label {
    color: var(--volan-blue);
    font-weight: 700;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 0.8rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: var(--volan-orange);
    box-shadow: 0 0 0 0.3rem rgba(255, 127, 80, 0.2);
    outline: none;
}

button[name="register"] {
    background: linear-gradient(135deg, var(--volan-green), var(--volan-yellow));
    color: white;
    padding: 0.8rem;
    border: none;
    border-radius: 50px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 1.5rem;
    box-shadow: 0 8px 20px rgba(50, 205, 50, 0.4);
}

button[name="register"]:hover {
    background: linear-gradient(135deg, var(--volan-yellow), var(--volan-green));
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(50, 205, 50, 0.6);
}

.login-link {
    color: var(--volan-purple);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.login-link:hover {
    color: var(--volan-yellow);
    transform: translateX(5px);
}

@keyframes bounceIn {
    0% {
        transform: scale(0.5);
        opacity: 0;
    }
    80% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
    }
}
