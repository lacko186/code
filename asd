:root {
    --primary-blue: #004b93;
    --primary-yellow: #ffd800;
    --accent-orange: #FF7F50;
    --accent-purple: #8A2BE2;
    --accent-green: #32CD32;
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
    font-family: 'Poppins', sans-serif;
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
    padding: 3rem;
    background: linear-gradient(135deg, #FFFFFF, #F0F0F0);
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    animation: fadeIn 1.5s ease-out;
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

.icon-container {
    text-align: center;
    margin-bottom: 2.5rem;
    animation: bounceIn 1.5s ease-out;
}

.icon-container i {
    font-size: 4rem;
    background: linear-gradient(90deg, var(--primary-blue), var(--accent-purple), var(--primary-yellow));
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
    color: var(--primary-blue);
    font-weight: 700;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 1rem;
    border: 2px solid #ddd;
    border-radius: 12px;
    transition: all 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: var(--accent-orange);
    box-shadow: 0 0 0 0.3rem rgba(255, 127, 80, 0.2);
    outline: none;
}

button[name="register"] {
    background: linear-gradient(135deg, var(--accent-green), var(--primary-yellow));
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 50px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 1.5rem;
    box-shadow: 0 10px 25px rgba(50, 205, 50, 0.4);
}

button[name="register"]:hover {
    background: linear-gradient(135deg, var(--primary-yellow), var(--accent-green));
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(50, 205, 50, 0.6);
}

.login-link {
    color: var(--accent-purple);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.login-link:hover {
    color: var(--primary-yellow);
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

/* Adding new elements and modernizing design */
.footer {
    background: #20232a;
    padding: 2rem 0;
    text-align: center;
    color: #ffffff;
    border-top: 3px solid var(--primary-blue);
}
.footer p {
    margin: 0;
}
.footer a {
    color: var(--primary-yellow);
    text-decoration: none;
}
.footer a:hover {
    color: var(--accent-orange);
}

/* New elements for additional sections */
.testimonial {
    background: rgba(0, 0, 0, 0.7);
    padding: 2rem;
    border-radius: 15px;
    margin-top: 2rem;
}
.testimonial h3 {
    color: var(--primary-blue);
    margin-bottom: 1rem;
}
.testimonial p {
    color: #dddddd;
}
.testimonial .author {
    color: var(--accent-orange);
    margin-top: 1rem;
    font-weight: 700;
}

.newsletter {
    background: rgba(255, 255, 255, 0.9);
    padding: 2rem;
    border-radius: 15px;
    margin-top: 2rem;
    text-align: center;
}
.newsletter h3 {
    color: var(--primary-blue);
    margin-bottom: 1rem;
}
.newsletter p {
    color: #555555;
    margin-bottom: 1.5rem;
}
.newsletter input[type="email"] {
    padding: 0.8rem;
    border: 2px solid #ddd;
    border-radius: 25px;
    transition: all 0.3s;
    width: 80%;
    max-width: 400px;
    margin-bottom: 1.5rem;
}
.newsletter input[type="email"]:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 0.3rem rgba(0, 75, 147, 0.2);
    outline: none;
}
.newsletter button {
    background: var(--primary-blue);
    color: white;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}
.newsletter button:hover {
    background: var(--accent-orange);
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(255, 127, 80, 0.6);
}

@media (max-width: 768px) {
    .register-container {
        padding: 2rem;
    }
    .icon-container i {
        font-size: 3rem;
    }
    button[name="register"] {
        padding: 0.7rem;
    }
}
