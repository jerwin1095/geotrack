<?php
session_start();
$error = '';

// Include your database connection
require_once 'db_connect.php'; // This file should set up $conn for Neon/Postgres

// Handle login POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    // Sanitize user input
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Parameterized query (prevents SQL injection)
    $sql = "SELECT password FROM admins WHERE username = $1";
    $result = pg_query_params($conn, $sql, [$username]);

    if ($result && pg_num_rows($result) === 1) {
        $row = pg_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Check password using PHP's password_verify
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geo-TrackDTR | Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #1f2937; }
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="form-container">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-2">
                <i class="fas fa-user-shield text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Login</h1>
            <p class="text-gray-600">Access your dashboard</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600 text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
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
        <div class="mt-4 text-center">
            <a href="signup.php" class="text-sm text-gray-600 hover:underline">Don't have an account? Sign up</a>
        </div>
    </div>
</body>
</html>
