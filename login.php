<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
session_start();

$error = '';
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'Invalid username format.';
    } else {
        $query = "SELECT id, username, password, role FROM users WHERE username = $1";
        $result = pg_query_params($conn, $query, [$username]);

        if ($result && pg_num_rows($result) === 1) {
            $user = pg_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header('Location: dashboard.php');
                } elseif ($user['role'] === 'user') {
                    header('Location: user_dashboard.php');
                } else {
                    $error = 'Unknown role assigned.';
                }
                exit();
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'Username not found.';
        }
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
    </div>
</body>
</html>
