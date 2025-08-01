<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Geo-TrackDTR | Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <style>
  #locationMap {
  height: 400px;
  z-index: 10;
}
.leaflet-pane {
  z-index: 10 !important;
}
.leaflet-control-container {
  z-index: 20 !important;
}
#assignUsersModal {
  z-index: 9999 !important;
}

</style>

</head>
<body class="bg-gray-100 font-sans">

  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 text-lg font-bold border-b border-gray-700 flex items-center gap-2">
        <i class="fas fa-user-shield"></i>
        Admin Dashboard
      </div>
      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <a href="#" class="flex items-center gap-2 text-white bg-gray-700 p-2 rounded"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="user.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
  <i class="fas fa-users"></i> User Management
</a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded"><i class="fas fa-clock"></i> Time Records</a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded"><i class="fas fa-map-marker-alt"></i> Location History</a>
        <div class="text-xs text-gray-400 mt-4">Settings</div>
        <a href="#" id="openAdminProfile" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded"><i class="fas fa-user-cog"></i> Admin Profile</a>
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded"><i class="fas fa-cog"></i> System Settings</a>
        <a href="logout.php" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded mt-4">
  <i class="fas fa-sign-out-alt"></i> Logout
</a>

      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <!-- Top Bar -->
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

      <!-- Dashboard Cards -->
      <section class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
          <div><p class="text-gray-500">Total Users</p><h2 class="text-2xl font-bold">150</h2></div>
          <i class="fas fa-users text-blue-600 text-2xl"></i>
        </div>
        <div class="bg-white p-4 rounded shadow flex justify-between items-center">
          <div><p class="text-gray-500">Active Users</p><h2 class="text-2xl font-bold">120</h2></div>
          <i class="fas fa-user-check text-green-600 text-2xl"></i>
        </div>
</section>
      <!-- User Management -->
     <section class="p-6">
  <div class="bg-white rounded shadow overflow-hidden">
    <div class="p-4 border-b flex justify-between">
      <h2 class="font-semibold">User Management</h2>
      <button class="bg-blue-600 text-white px-4 py-1 rounded">Add User</button>
    </div>

 <section class="p-6">
  <div class="bg-white rounded shadow overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
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
          <?php
          require_once 'db_connect.php';
          $query = "SELECT id, name, email, phone FROM users ORDER BY id ASC";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
          ?>
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
<!-- Map Section (insert this somewhere visible on the page) -->
<section class="p-6">
  <div class="bg-white rounded shadow p-4">
    <h2 class="text-lg font-semibold mb-4">Search & Assign Location</h2>
    <div id="locationMap" class="w-full h-96 rounded border"></div>
    <div class="mt-4 flex justify-start">
  <button id="openAssignModal" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Assign Employee
  </button>
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
          <?php
          require_once 'db_connect.php';
          $today = date('Y-m-d');
          $query = "
            SELECT users.name, users.location, attendance.id AS attendance_id, attendance.time_in, attendance.time_out
            FROM users
            LEFT JOIN attendance ON users.id = attendance.user_id AND DATE(attendance.time_in) = '$today'
            WHERE users.location IS NOT NULL AND users.location != ''
            ORDER BY users.name ASC
          ";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
          ?>
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




  </div>
</section>

    </main>
  </div>

  <!-- Admin Profile Modal -->
  <div id="adminProfileModal" class="fixed inset-0 z-1000 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">
      <button onclick="toggleAdminProfileModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h2 class="text-xl font-semibold mb-4">Admin Profile</h2>
      <div class="space-y-4">
        <div>
          <label class="block text-sm text-gray-700">Full Name</label>
          <input type="text" class="w-full mt-1 p-2 border rounded-md" value="Admin User">
        </div>
        <div>
          <label class="block text-sm text-gray-700">Email</label>
          <input type="email" class="w-full mt-1 p-2 border rounded-md" value="admin@example.com">
        </div>
        <div>
          <label class="block text-sm text-gray-700">Password</label>
          <input type="password" class="w-full mt-1 p-2 border rounded-md" value="password123">
        </div>
        <div class="flex justify-end gap-2">
          <button onclick="toggleAdminProfileModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        </div>
      </div>
     



    </div>
  </div>

  <!-- Scripts -->
  <script>
  let selectedLocation = null;
  let currentMarker = null;

  function toggleAssignUsersModal() {
    const modal = document.getElementById('assignUsersModal');
    if (modal) {
      modal.classList.toggle('hidden');
    }
  }

  function toggleAdminProfileModal() {
    const modal = document.getElementById('adminProfileModal');
    if (modal) {
      modal.classList.toggle('hidden');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('locationMap').setView([7.1907, 125.4553], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // ✅ Geocoder Search
    L.Control.geocoder({
      defaultMarkGeocode: true
    })
    .on('markgeocode', function (e) {
      const latlng = e.geocode.center;
      const name = e.geocode.name;

      // Remove existing marker
      if (currentMarker) map.removeLayer(currentMarker);

      // Set marker
      currentMarker = L.marker(latlng).addTo(map).bindPopup(name).openPopup();

      // Save location
      selectedLocation = {
        name: name,
        lat: latlng.lat,
        lng: latlng.lng
      };

      document.getElementById('selectedLocationInput').value = name;
    })
    .addTo(map);

    // ✅ Map Click
    map.on('click', function (e) {
      const latlng = e.latlng;

      // Remove previous marker
      if (currentMarker) map.removeLayer(currentMarker);

      const name = `Lat: ${latlng.lat.toFixed(4)}, Lng: ${latlng.lng.toFixed(4)}`;

      currentMarker = L.marker(latlng).addTo(map).bindPopup(name).openPopup();

      selectedLocation = {
        name: name,
        lat: latlng.lat,
        lng: latlng.lng
      };

      document.getElementById('selectedLocationInput').value = name;
    });

    // ✅ Open Assign Modal
    const assignBtn = document.getElementById('openAssignModal');
    if (assignBtn) {
      assignBtn.addEventListener('click', function () {
        if (!selectedLocation) {
          alert('Please select a location by clicking on the map or using the search.');
          return;
        }
        document.getElementById('selectedLocationInput').value = selectedLocation.name;
        toggleAssignUsersModal();
      });
    }
  });
</script>

<script>
  document.getElementById('assignUsersForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const locationName = document.getElementById('selectedLocationInput').value;
   document.getElementById('hiddenLocationInput').value = locationName;
formData.set('location_name', locationName);


    fetch('assign_location.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        toggleAssignUsersModal();
        location.reload(); // refresh the dashboard
      }
    })
    .catch(err => {'
      console.error('Error:', err);
      alert('An error occurred.');
    });
  });

  require 'db_connect.php';
</script>



 <!-- Assign Users Modal -->
<!-- Admin Profile Modal -->
<div id="adminProfileModal" class="fixed inset-0 z-1000 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">
    ...
  </div>
</div>

<!-- ✅ Move this OUTSIDE of adminProfileModal -->
<!-- Assign Users Modal -->
<div id="assignUsersModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative max-h-[80vh] overflow-y-auto">
    <button onclick="toggleAssignUsersModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
    <h2 class="text-lg font-semibold mb-4">Assign Employees to Location</h2>

    <!-- Location Display -->
    <div class="mb-4">
      <label class="block text-sm text-gray-600 mb-1">Location</label>
      <input type="text" id="selectedLocationInput" class="w-full border p-2 rounded" disabled>
    </div>

    <!-- User List -->
    <form id="assignUsersForm">
  <input type="hidden" name="location_name" id="hiddenLocationInput">
  <div class="space-y-3">
    <?php
    require_once 'db_connect.php';
      $userQuery = "SELECT id, name, location FROM users";
      $userResult = $conn->query($userQuery);
      while ($user = $userResult->fetch_assoc()):
        $isAssigned = !empty($user['location']);
    ?>
    <div class="flex items-center justify-between bg-gray-50 hover:bg-gray-100 p-2 rounded">
      <span class="font-medium text-gray-800"><?= htmlspecialchars($user['name']) ?></span>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="selected_users[]" value="<?= $user['id'] ?>"
          class="appearance-none w-5 h-5 border-2 border-gray-400 rounded-full 
                 checked:bg-blue-600 checked:border-blue-600 checked:ring-2 checked:ring-blue-300
                 focus:outline-none transition" />

        <?php if ($isAssigned): ?>
        <!-- Delete / Unassign button -->
        <button type="button" onclick="unassignUser(<?= $user['id'] ?>)" class="text-red-500 hover:text-red-700">
          <i class="fas fa-trash-alt"></i>
        </button>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

  <!-- Action Buttons -->
  <div class="mt-6 flex justify-end gap-2">
    <button type="button" onclick="toggleAssignUsersModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Assign</button>
  </div>
</form>

  </div>
</div>


</body>
</html>