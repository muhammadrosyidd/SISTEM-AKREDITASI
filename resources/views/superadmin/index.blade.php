<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/polinema_logo.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>KREDITASI D4 SIB</title>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">User Management</h6>
                            <!-- Button to open modal -->
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fas fa-plus me-1"></i> Add User
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="px-3 mt-3">
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                            </div>
                            <div class="table-responsive p-3">
                                <table class="table align-items-center mb-0" id="usersTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="10%">ID</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="25%">Username</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="25%">Name</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="20%">Role</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center" width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <span class="text-xs font-weight-bold">{{ $user->id_user }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-xs font-weight-normal">{{ $user->username }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-xs font-weight-normal">{{ $user->nama_user }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-xs font-weight-normal">{{ $user->getRoleName() }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-action-group d-flex justify-content-center">
                                                    <button class="btn btn-warning btn-sm me-2 btn-edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal"
                                                            data-user-id="{{ $user->id_user }}"
                                                            data-username="{{ $user->username }}"
                                                            data-nama-user="{{ $user->nama_user }}"
                                                            data-role-id="{{ $user->id_role }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit fa-xs"></i> Edit
                                                    </button>
                                                    <form action="{{ route('superadmin.users.destroy', $user->id_user) }}" method="POST" class="d-inline-block delete-user-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm btn-delete" title="Delete">
        <i class="fas fa-trash fa-xs"></i> Delete
    </button>
</form>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Add User Modal -->
    @include('superadmin.create')

    <!-- Include Edit User Modal -->
    @include('superadmin.edit')

    <script>
    // Ensure modal closes properly on cancel
    document.querySelector('.btn-secondary').addEventListener('click', function() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        modal.hide(); // Close the modal
        document.getElementById('editUserForm').reset(); // Optionally reset the form
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</body>

</html>
