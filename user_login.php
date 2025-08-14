<?php
session_start();
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Geo-TrackDTR | User Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="" crossorigin="anonymous" />
  <style>
    body {
      background-color: #1f2937; /* Tailwind gray-800 */
    }
    .form-container {
      max-width: 400px;
      margin: auto;
      padding: 2rem;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
    }
    .form-container:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen">

  <div class="form-container">
    <div class="text-center mb-6">
      <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-2">
        <i class="fas fa-map-marker-alt text-white text-3xl"></i>
      </div>
      <h1 class="text-2xl font-bold text-gray-800">User Login</h1>
      <p class="text-gray-600">Track your attendance effortlessly</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="mb-4 text-red-600 text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="user_authenticate.php" autocomplete="off">
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" required
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500"
               placeholder="Enter your username">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500"
               placeholder="Enter your password">
      </div>
      <button type="submit"
              class="w-full py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition duration-200 ease-in-out">
        Login
      </button>
    </form>

    <div class="mt-4 text-center text-gray-500 text-sm">
      Need help? Contact your administrator.
    </div>
  </div>

</body>
</html>
