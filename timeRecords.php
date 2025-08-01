<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Geo-TrackDTR | Time Records</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 text-lg font-bold border-b border-gray-700 flex items-center gap-2">
        <i class="fas fa-user-shield"></i> Admin Dashboard
      </div>
      <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <a href="dashboard.html" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="user-management.html" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded">
          <i class="fas fa-users"></i> User Management
        </a>
        <a href="time-records.html" class="flex items-center gap-2 text-white bg-gray-700 p-2 rounded">
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
        <a href="#" class="flex items-center gap-2 text-gray-300 hover:text-white hover:bg-gray-700 p-2 rounded mt-4">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <!-- Top Bar -->
      <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Time Records</h1>
        <button onclick="openAddRecordModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          <i class="fas fa-plus mr-2"></i> Add Record
        </button>
      </header>

      <!-- Time Records Table -->
      <section class="p-6">
        <div class="bg-white rounded shadow overflow-hidden">
          <table class="w-full text-left divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="p-3">User ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Date</th>
                <th class="p-3">Time In</th>
                <th class="p-3">Time Out</th>
                <th class="p-3">Actions</th>
              </tr>
            </thead>
            <tbody id="recordsTableBody" class="divide-y divide-gray-200"></tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <!-- Add/Edit Modal -->
  <div id="recordModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">
      <button onclick="toggleRecordModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
      <h2 id="recordModalTitle" class="text-xl font-semibold mb-4">Add Time Record</h2>
      <input type="hidden" id="editRecordIndex" />
      <div class="space-y-4">
        <div>
          <label class="block text-sm text-gray-700">Name</label>
          <input type="text" id="recordName" class="w-full mt-1 p-2 border rounded-md" />
        </div>
        <div>
          <label class="block text-sm text-gray-700">Date</label>
          <input type="date" id="recordDate" class="w-full mt-1 p-2 border rounded-md" />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-gray-700">Time In</label>
            <input type="time" id="recordTimeIn" class="w-full mt-1 p-2 border rounded-md" />
          </div>
          <div>
            <label class="block text-sm text-gray-700">Time Out</label>
            <input type="time" id="recordTimeOut" class="w-full mt-1 p-2 border rounded-md" />
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button onclick="toggleRecordModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
          <button onclick="saveRecord()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    let records = [
      { id: 'EMP-001', name: 'Juan Dela Cruz', date: '2025-07-11', timeIn: '08:00', timeOut: '17:00' },
      { id: 'EMP-002', name: 'Maria Santos', date: '2025-07-11', timeIn: '08:30', timeOut: '17:30' }
    ];

    function renderRecords() {
      const tbody = document.getElementById('recordsTableBody');
      tbody.innerHTML = '';
      records.forEach((record, index) => {
        tbody.innerHTML += `
          <tr>
            <td class="p-3">${record.id}</td>
            <td class="p-3">${record.name}</td>
            <td class="p-3">${record.date}</td>
            <td class="p-3">${record.timeIn}</td>
            <td class="p-3">${record.timeOut}</td>
            <td class="p-3">
              <button onclick="editRecord(${index})" class="text-blue-500 hover:underline">Edit</button>
              <button onclick="deleteRecord(${index})" class="text-red-500 hover:underline ml-2">Delete</button>
            </td>
          </tr>
        `;
      });
    }

    function toggleRecordModal() {
      document.getElementById('recordModal').classList.toggle('hidden');
      document.getElementById('editRecordIndex').value = '';
      document.getElementById('recordModalTitle').textContent = 'Add Time Record';
      document.getElementById('recordName').value = '';
      document.getElementById('recordDate').value = '';
      document.getElementById('recordTimeIn').value = '';
      document.getElementById('recordTimeOut').value = '';
    }

    function openAddRecordModal() {
      toggleRecordModal();
    }

    function saveRecord() {
      const name = document.getElementById('recordName').value.trim();
      const date = document.getElementById('recordDate').value;
      const timeIn = document.getElementById('recordTimeIn').value;
      const timeOut = document.getElementById('recordTimeOut').value;
      const index = document.getElementById('editRecordIndex').value;

      if (!name || !date || !timeIn || !timeOut) {
        alert('All fields are required!');
        return;
      }

      if (index === '') {
        const newId = `EMP-${(records.length + 1).toString().padStart(3, '0')}`;
        records.push({ id: newId, name, date, timeIn, timeOut });
      } else {
        records[index] = { ...records[index], name, date, timeIn, timeOut };
      }

      renderRecords();
      toggleRecordModal();
    }

    function editRecord(index) {
      const record = records[index];
      document.getElementById('editRecordIndex').value = index;
      document.getElementById('recordModalTitle').textContent = 'Edit Time Record';
      document.getElementById('recordName').value = record.name;
      document.getElementById('recordDate').value = record.date;
      document.getElementById('recordTimeIn').value = record.timeIn;
      document.getElementById('recordTimeOut').value = record.timeOut;
      toggleRecordModal();
    }

    function deleteRecord(index) {
      if (confirm('Are you sure you want to delete this record?')) {
        records.splice(index, 1);
        renderRecords();
      }
    }

    document.addEventListener('DOMContentLoaded', renderRecords);
  </script>
</body>
</html>
