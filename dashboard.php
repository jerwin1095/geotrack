<?php
require_once 'db_connect.php';

// Total Users
$userCount = 0;
$res = pg_query($conn, "SELECT COUNT(*) FROM users");
if ($res) {
  $row = pg_fetch_row($res);
  $userCount = $row[0];
}

// Active Users (users with location set)
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
$usersRes = pg_query($conn, "SELECT id, name, email, phone, location FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Geo-TrackDTR | Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <style>
    #locationMap { height: 400px; z-index: 10; }
    .leaflet-pane { z-index: 10 !important; }
    .leaflet-control-container { z-index: 20 !important; }
    #assignUsersModal { z-index: 9999 !important; }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <!-- Sidebar and Main Content ... (same as your existing code above) ... -->

  <!-- ... All your HTML content from your current dashboard.php ... -->

  <!-- Assign Users Modal -->
  <div id="assignUsersModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative max-h-[80vh] overflow-y-auto">
      <button onclick="toggleAssignUsersModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h2 class="text-lg font-semibold mb-4">Assign Employees to Location</h2>
      <div class="mb-4">
        <label class="block text-sm text-gray-600 mb-1">Location</label>
        <input type="text" id="selectedLocationInput" class="w-full border p-2 rounded" disabled>
      </div>
      <form id="assignUsersForm">
        <input type="hidden" name="location_name" id="hiddenLocationInput">
        <div class="space-y-3">
          <?php
          $userQuery = "SELECT id, name, location FROM users";
          $userResult = pg_query($conn, $userQuery);
          if ($userResult && pg_num_rows($userResult) > 0):
            while ($user = pg_fetch_assoc($userResult)):
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
              <button type="button" onclick="unassignUser(<?= $user['id'] ?>)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash-alt"></i>
              </button>
              <?php endif; ?>
            </div>
          </div>
          <?php endwhile; endif; ?>
        </div>
        <div class="mt-6 flex justify-end gap-2">
          <button type="button" onclick="toggleAssignUsersModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Assign</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    let selectedLocation = null;
    let currentMarker = null;
    function toggleAssignUsersModal() {
      const modal = document.getElementById('assignUsersModal');
      if (modal) modal.classList.toggle('hidden');
    }
    document.addEventListener('DOMContentLoaded', function () {
      const map = L.map('locationMap').setView([7.1907, 125.4553], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);
      L.Control.geocoder({
        defaultMarkGeocode: true
      })
      .on('markgeocode', function (e) {
        const latlng = e.geocode.center;
        const name = e.geocode.name;
        if (currentMarker) map.removeLayer(currentMarker);
        currentMarker = L.marker(latlng).addTo(map).bindPopup(name).openPopup();
        selectedLocation = { name: name, lat: latlng.lat, lng: latlng.lng };
        document.getElementById('selectedLocationInput').value = name;
      })
      .addTo(map);
      map.on('click', function (e) {
        const latlng = e.latlng;
        if (currentMarker) map.removeLayer(currentMarker);
        const name = `Lat: ${latlng.lat.toFixed(4)}, Lng: ${latlng.lng.toFixed(4)}`;
        currentMarker = L.marker(latlng).addTo(map).bindPopup(name).openPopup();
        selectedLocation = { name: name, lat: latlng.lat, lng: latlng.lng };
        document.getElementById('selectedLocationInput').value = name;
      });
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
    // Assign location AJAX
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
          location.reload();
        }
      })
      .catch(err => {
        console.error('Error:', err);
        alert('An error occurred.');
      });
    });
    // Unassign user AJAX
    function unassignUser(userId) {
      fetch('unassign_location.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'user_id=' + encodeURIComponent(userId)
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        if (data.success) {
          location.reload();
        }
      })
      .catch(err => {
        console.error('Error:', err);
        alert('An error occurred.');
      });
    }
  </script>
</body>
</html>
