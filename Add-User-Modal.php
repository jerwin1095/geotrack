<!-- Add User Modal -->
<div id="addUserModal" class="modal fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50" style="display:none;">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
    <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
    <h3 class="text-lg font-semibold mb-4">Add New User</h3>
    <form method="post">
      <input type="hidden" name="add_user" value="1">
      <label class="block text-sm mb-1">Name</label>
      <input name="name" class="w-full border p-2 rounded mb-2" required>
      <label class="block text-sm mb-1">Email</label>
      <input name="email" type="email" class="w-full border p-2 rounded mb-2" required>
      <label class="block text-sm mb-1">Phone</label>
      <input name="phone" class="w-full border p-2 rounded mb-4">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Add User</button>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('addUserModal').style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('addUserModal').style.display = 'none';
  }
  document.getElementById('addUserModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
</script>
