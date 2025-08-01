<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = pg_query_params(
        $conn,
        "SELECT * FROM users WHERE username = $1 AND password = $2",
        [$username, $password]
    );

    if ($result && pg_num_rows($result) === 1) {
        $user = pg_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Geo-TrackDTR</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="mb-4">
        <label class="block text-gray-700 mb-1" for="username">Username</label>
        <input type="text" id="username" name="username" class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 mb-1" for="password">Password</label>
        <input type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white rounded py-2 font-semibold hover:bg-blue-700 transition">Login</button>
    </form>
  </div>
</body>
</html>
