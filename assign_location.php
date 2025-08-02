<?php
require_once 'db_connect.php';

$user_id = $_GET['user_id'] ?? null;
$temp_pass = $_GET['temp_pass'] ?? '';
$email_sent = $_GET['email_sent'] ?? 0;
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $location = $_POST['location'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $email = $_POST['email'] ?? '';
    // Update user's location
    $res = pg_query_params($conn, "UPDATE users SET location=$1 WHERE id=$2", [$location, $user_id]);
    if ($res) {
        // Send email
        $subject = "Your Geo-TrackDTR Account";
        $message = "Hello,\n\nYou have been assigned to location: $location.\n\nLogin at: http://yourdomain.com/login.php\nUsername: $email\nPassword: $temp_pass\n\nPlease change your password after logging in.";
        $headers = "From: noreply@yourdomain.com";
        if (mail($email, $subject, $message, $headers)) {
            $success = "User assigned and email sent successfully!";
        } else {
            $error = "User assigned, but email failed to send.";
        }
    } else {
        $error = "Could not assign location: " . pg_last_error($conn);
    }
}

// Fetch user info
$user = null;
if ($user_id) {
    $result = pg_query_params($conn, "SELECT name, email, location FROM users WHERE id=$1", [$user_id]);
    $user = $result ? pg_fetch_assoc($result) : null;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Assign Location</title>
  <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100">
  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Assign Location to User</h2>
    <?php if ($error): ?><div class="mb-2 text-red-600"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="mb-2 text-green-600"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($user): ?>
    <form method="post">
      <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
      <label>User</label>
      <input value="<?= htmlspecialchars($user['name']) ?>" class="w-full p-2 border rounded mt-1 mb-2" disabled>
      <label>Location</label>
      <input name="location" value="<?= htmlspecialchars($user['location']) ?>" class="w-full p-2 border rounded mt-1 mb-4" required>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Assign & Send Email</button>
    </form>
    <?php endif; ?>
  </div>
</body>
</html>
