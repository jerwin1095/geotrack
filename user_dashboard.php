<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$userRes = pg_query_params($conn, "SELECT * FROM users WHERE id = $1", [$userId]);
$user = pg_fetch_assoc($userRes);

$today = date('Y-m-d');
$attendanceRes = pg_query_params($conn, "SELECT * FROM attendance WHERE user_id = $1 AND DATE(time_in) = $2", [$userId, $today]);
$attendance = pg_fetch_assoc($attendanceRes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Geo-TrackDTR | User Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Welcome, <?= htmlspecialchars($user['name']) ?></h1>
    <a href="logout.php" class="text-red-600 hover:text-red-800">Logout</a>
  </header>

  <main class="p-6">
    <!-- Attendance Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Today's Attendance</h2>
        <p><strong>Date:</strong> <?= date('F j, Y') ?></p>
        <p><strong>Time In:</strong> <?= $attendance && $attendance['time_in'] ? date('h:i A', strtotime($attendance['time_in'])) : '-' ?></p>
        <p><strong>Time Out:</strong> <?= $attendance && $attendance['time_out'] ? date('h:i A', strtotime($attendance['time_out'])) : '-' ?></p>
      </div>

      <!-- Location Info -->
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Assigned Location</h2>
        <?php if (!empty($user['location'])): ?>
          <div id="userLocationMap" class="h-64 w-full rounded border"></div>
          <p class="mt-2 text-sm text-gray-600"><?= htmlspecialchars($user['location']) ?></p>
        <?php else: ?>
          <p class="text-gray-500">No location assigned.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Profile Section -->
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-lg font-semibold mb-4">My Profile</h2>
      <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      <!-- Add update profile button if needed -->
    </div>
  </main>

  <!-- Leaflet Map Script -->
  <script>
    <?php if (!empty($user['location'])): ?>
    document.addEventListener('DOMContentLoaded', function () {
      const map = L.map('userLocationMap').setView([7.1907, 125.4553], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      const location = <?= json_encode($user['location']) ?>;
      const coordsMatch = location.match(/Lat:\s*(-?\d+(\.\d+)?),\s*Lng:\s*(-?\d+(\.\d+)?)/);
      if (coordsMatch) {
        const lat = parseFloat(coordsMatch[1]);
        const lng = parseFloat(coordsMatch[3]);
        L.marker([lat, lng]).addTo(map).bindPopup("Assigned Location").openPopup();
        map.setView([lat, lng], 15);
      }
    });
    <?php endif; ?>
  </script>
</body>
</html>
