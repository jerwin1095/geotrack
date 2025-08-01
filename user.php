<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Geo-TrackDTR | User Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<script>
  function toggleUserModal() {
    document.getElementById('userModal').classList.toggle('hidden');
  }

  function openAddUserModal() {
    toggleUserModal();
  }
</script>

<body class="bg-gray-100 font-sans">

  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 text-lg font-bold border-b border-gray-700 flex items-center gap-2">
        <i class="fas fa-user-shield"></i> Admin Dashboard
      </div>
      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <a href="dashboard.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="user.php" class="flex items-center gap-2 text-white bg-gray-700 p-2 rounded">
          <i class="fas fa-users"></i> User Management
        </a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-clock"></i> Time Records
        </a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-map-marker-alt"></i> Location History
        </a>
        <div class="text-xs text-gray-400 mt-4">Settings</div>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-user-cog"></i> Admin Profile
        </a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-cog"></i> System Settings
        </a>
        <a href="logout.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded mt-4">
  <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <!-- Top Bar -->
      <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">User Management</h1>
        <button onclick="openAddUserModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          <i class="fas fa-user-plus mr-2"></i> Add User
        </button>
      </header>

      <!-- User Table -->
      <section class="p-6">
        <div class="bg-white rounded shadow overflow-hidden">
          <table class="w-full text-left divide-y divide-gray-200">
            <thead class="bg-gray-50">
  <tr>
    <th class="p-3">User ID</th>
    <th class="p-3">Name</th>
    <th class="p-3">Phone</th> <!-- NEW -->
    <th class="p-3">Actions</th>
  </tr>
</thead>

            <tbody class="divide-y divide-gray-200">
  <?php
    require_once 'db_connect.php';
    $query = "SELECT * FROM users ORDER BY id DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
  ?>
    <tr>
  <td class="p-3"><?= htmlspecialchars($row['emp_id']) ?></td>
  <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
  <td class="p-3"><?= htmlspecialchars($row['phone']) ?></td> <!-- NEW -->
  <td class="p-3">
    <a href="edit_user.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a>
    <a href="delete_user.php?id=<?= $row['id'] ?>" class="text-red-500 hover:underline ml-2" onclick="return confirm('Delete this user?')">Delete</a>
  </td>
</tr>

  <?php
      endwhile;
    else:
  ?>
    <tr><td colspan="3" class="p-3 text-center text-gray-500">No users found.</td></tr>
  <?php endif; ?>
</tbody>

          </table>
        </div>
      </section>
    </main>
  </div>

<!-- Add User Modal -->
<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <form action="add_user.php" method="POST" class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">
    <button type="button" onclick="toggleUserModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
    <h2 class="text-xl font-semibold mb-4">Add User</h2>
    <div class="space-y-4">
      
      <!-- User ID Field -->
      <div>
        <label class="block text-sm text-gray-700">User ID</label>
        <input type="text" name="emp_id" class="w-full mt-1 p-2 border rounded-md" placeholder="e.g., EMP-001" required />
      </div>

      <!-- Name Field -->
      <div>
        <label class="block text-sm text-gray-700">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 border rounded-md" required />
      </div>

      <div>
  <label class="block text-sm text-gray-700">Phone Number</label>
  <input type="text" name="phone" class="w-full mt-1 p-2 border rounded-md" placeholder="e.g. 09123456789" required />
</div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="toggleUserModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
      </div>
    </div>
  </form>
</div>




  </script>
</body>
</html>
