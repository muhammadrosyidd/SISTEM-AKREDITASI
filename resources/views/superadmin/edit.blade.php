<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id" name="id_user">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_user" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="edit_nama_user" name="nama_user" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" placeholder="Leave blank to keep current password">
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                     <div class="mb-3">
                        <label for="edit_role_id" class="form-label">Role</label>
                        <select class="form-select" id="edit_role_id" name="id_role" required>
                            <option value="" disabled>Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id_role }}" 
                                        {{ old('id_role', $user->id_role) == $role->id_role ? 'selected' : '' }}>
                                    {{ $role->role_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editUserModal');
    
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button that triggered the modal
            
            const userId = button.getAttribute('data-user-id');
            const username = button.getAttribute('data-username');
            const namaUser = button.getAttribute('data-nama-user');
            const roleId = button.getAttribute('data-role-id');
            
            // Update form action URL
            document.getElementById('editUserForm').action = "{{ route('superadmin.users.update', ':id') }}".replace(':id', userId);
            
            // Fill form data
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_nama_user').value = namaUser;
            document.getElementById('edit_role_id').value = roleId; // Set the selected role
            
            // Clear password field every time the modal is opened
            document.getElementById('edit_password').value = '';
        });

        // Prevent form from submitting if validation fails
        editModal.querySelector('#editUserForm').addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    }
});

</script>