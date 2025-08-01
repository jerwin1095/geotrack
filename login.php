<?php
session_start();
$error = '';

// Include your database connection
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    echo "Checking if username exists...<br>";
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        echo "Username found in database.<br>";
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo-TrackDTR | Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #1f2937; /* Dark gray background */
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: #ffffff; /* White background for the form */
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="form-container">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-user-shield text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800" id="formTitle">Admin Login</h1>
            <p class="text-gray-600" id="formSubtitle">Access your dashboard</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form id="loginForm" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Enter your username">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Enter your password">
            </div>
            <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Login</button>
        </form>
        <form id="signupForm" class="hidden">
            <div class="mb-4">
                <label for="signupUsername" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="signupUsername" name="signupUsername" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Enter your username">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Enter your email">
            </div>
            <div class="mb-4">
                <label for="signupPassword" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="signupPassword" name="signupPassword" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Enter your password">
            </div>
            <div class="mb-4">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-500" placeholder="Confirm your password">
            </div>
            <button type="submit" class="w-full py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Sign Up</button>
        </form>
        <div class="mt-4 text-center">
            <a href="#" id="toggleForm" class="text-sm text-gray-600 hover:underline">Don't have an account? Sign up</a>
        </div>
    </div>

    <script>
        const toggleForm = document.getElementById('toggleForm');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        const formTitle = document.getElementById('formTitle');
        const formSubtitle = document.getElementById('formSubtitle');

        toggleForm.addEventListener('click', (e) => {
            e.preventDefault();
            if (loginForm.classList.contains('hidden')) {
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
                formTitle.textContent = 'Admin Login';
                formSubtitle.textContent = 'Access your dashboard';
                toggleForm.textContent = "Don't have an account? Sign up";
            } else {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                formTitle.textContent = 'Sign Up';
                formSubtitle.textContent = 'Create a new account';
                toggleForm.textContent = 'Already have an account? Login';
            }
        });
    </script>
</body>
</html>