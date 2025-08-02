<?php
require_once 'db_connect.php';

// Total Users
$userCount = 0;
$res = pg_query($conn, "SELECT COUNT(*) FROM users");
if ($res) {
  $row = pg_fetch_row($res);
  $userCount = $row[0];
}

// Active Users (example: users with location set)
$activeCount = 0;
$res = pg_query($conn, "SELECT COUNT(*) FROM users WHERE location IS NOT NULL AND location != ''");
if ($res) {
  $row = pg_fetch_row($res);
  $activeCount = $row[0];
}

// Today's Attendance
$today = date('Y-m-d');
$attendanceRes = pg_query($conn, "
  SELECT u.name, u.location, a.id AS attendance_id, a.time_in, a.time_out
  FROM users u
  LEFT JOIN attendance a ON u.id = a.user_id AND DATE(a.time_in) = '$today'
  WHERE u.location IS NOT NULL AND u.location != ''
  ORDER BY u.name ASC
");

// User List
$usersRes = pg_query($conn, "SELECT id, name, email, phone FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Geo-TrackDTR | Admin Dashboard</title>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex h-screen overflow-hidden">
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 text-lg font-bold border-b border-gray-700 flex items-center gap-2">
        <i class="fas fa-user-shield"></i> Admin Dashboard
      </div>
      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <a href="#" class="flex items-center gap-2 text-white bg-gray-700 p-2 rounded">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="user.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-users"></i> User Management
        </a>
        <!-- ... other nav links ... -->
        <a href="logout.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded mt-4">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
      <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Admin Dashboard</h1>
        <div class="flex items-center gap-4">
          <button class="relative text-gray-600 hover:text-gray-800">
            <i class="fas fa-bell"></i>
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
          </button>
          <img src="https://placehold.co/32x32" alt="Admin" class="rounded-full h-8 w-8">
        </div>
      </header>

      <section class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
          <div>
            <p class="text-gray-500">Total Users</p>
            <h2 class="text-2xl font-bold"><?= $userCount ?></h2>
          </div>
          <i class="fas fa-users text-blue-600 text-2xl"></i>
        </div>
        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
          <div>
            <p class="text-gray-500">Active Users</p>
            <h2 class="text-2xl font-bold"><?= $activeCount ?></h2>
          </div>
          <i class="fas fa-user-check text-green-600 text-2xl"></i>
        </div>
      </section>

      <!-- User Management -->
      <section class="p-6">
        <div class="bg-white rounded shadow overflow-hidden">
          <div class="p-4 border-b flex justify-between">
            <h2 class="font-semibold">User Management</h2>
            <a href="add_user.php" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Add User</a>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID Number</th>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Phone</th>
                  <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($usersRes && pg_num_rows($usersRes) > 0):
                  while ($row = pg_fetch_assoc($usersRes)): ?>
                    <tr>
                      <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['id']) ?></td>
                      <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($row['name']) ?></td>
                      <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['email']) ?></td>
                      <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($row['phone']) ?></td>
                      <td class="px-6 py-4 text-sm">
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Delete this user?')">Delete</a>
                      </td>
                    </tr>
                  <?php endwhile; else: ?>
                  <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Attendance as of Today -->
      <section class="p-6">
        <div class="bg-white rounded shadow overflow-hidden">
          <div class="p-4 border-b">
            <h2 class="font-semibold">Attendance as of <?= date('F d, Y') ?></h2>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="p-3 text-left text-sm font-medium text-gray-500">Name</th>
                  <th class="p-3 text-left text-sm font-medium text-gray-500">Location</th>
                  <th class="p-3 text-left text-sm font-medium text-gray-500">Time In</th>
                  <th class="p-3 text-left text-sm font-medium text-gray-500">Time Out</th>
                  <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($attendanceRes && pg_num_rows($attendanceRes) > 0):
                  while ($row = pg_fetch_assoc($attendanceRes)): ?>
                    <tr>
                      <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
                      <td class="p-3"><?= htmlspecialchars($row['location'] ?? '-') ?></td>
                      <td class="p-3"><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : '-' ?></td>
                      <td class="p-3"><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : '-' ?></td>
                      <td class="p-3">
                        <?php if (!empty($row['attendance_id'])): ?>
                          <form action="delete_attendance.php" method="POST" onsubmit="return confirm('Delete this attendance record?');">
                            <input type="hidden" name="attendance_id" value="<?= $row['attendance_id'] ?>">
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Attendance">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        <?php else: ?>
                          <span class="text-gray-400">-</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endwhile; else: ?>
                  <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">No attendance records for today.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
