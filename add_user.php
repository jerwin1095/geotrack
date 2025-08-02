<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $location = $_POST['location'] ?? '';
    $password = bin2hex(random_bytes(4)); // 8-char random password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $sql = "INSERT INTO users (name, email, phone, location, password) VALUES ($1, $2, $3, $4, $5) RETURNING id";
    $result = pg_query_params($conn, $sql, [$name, $email, $phone, $location, $hashed]);
    if ($result && $row = pg_fetch_assoc($result)) {
        $user_id = $row['id'];
        // Optionally: Send email here...
        header("Location: assign_location.php?user_id=$user_id&email_sent=0&temp_pass=$password");
        exit;
    } else {
        $error = "User creation failed: " . pg_last_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add User</title>
  <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100">
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add User</h2>
    <?php if (!empty($error)): ?>
      <div class="mb-2 text-red-600"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <label>Name</label>
      <input name="name" class="w-full p-2 border rounded mt-1 mb-2" required>
      <label>Email</label>
      <input name="email" type="email" class="w-full p-2 border rounded mt-1 mb-2" required>
      <label>Phone</label>
      <input name="phone" class="w-full p-2 border rounded mt-1 mb-2">
      <label>Location (optional)</label>
      <input name="location" class="w-full p-2 border rounded mt-1 mb-4">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Add User</button>
    </form>
  </div>
</body>
</html>
