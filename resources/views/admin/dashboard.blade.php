<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
    <head>
        <style>
            body {
                background: url('background.jpg') no-repeat center center fixed; 
                background-size: cover;
                position: relative;
            }
    
            /* Add an overlay for better readability */
            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(47, 4, 71, 0.5); /* Adjust opacity as needed */
                z-index: -1;
            }
    
            .container {
                position: relative;
                z-index: 1;
                background: rgba(91, 6, 93, 0.85); /* Light background for contrast */
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }
    
            .table {
                background: white;
            }
        </style>
    </head>
    
    <body>
        <div class="overlay"></div>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="button" class="btn btn-danger"
                        onclick="window.location.href='{{ route('admin.adminlogin') }}'">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">User Management</h2>
        
        <div class="mb-3 d-flex align-items-center gap-2">
            <a href="{{ route('users.export') }}" class="btn btn-success">Export Users</a>
        
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                @csrf
                <input type="file" name="file" class="form-control" required>
                <button type="submit" class="btn btn-primary">Import Users</button>
            </form>
        </div>
        
        <!-- Export Users Based on Date Range -->
        <div class="mb-3">
            <h4>Export Users Based on Date Range</h4>
            <form action="{{ route('users.export.filtered') }}" method="GET" class="d-flex gap-2 align-items-center">
                <label for="start_date" class="fw-bold">From:</label>
                <input type="text" id="start_date" name="start_date" class="form-control" required>
        
                <label for="end_date" class="fw-bold">To:</label>
                <input type="text" id="end_date" name="end_date" class="form-control" required>
        
                <button type="submit" class="btn btn-success">Export Filtered Users</button>
            </form>
        </div>
        


        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Serial no.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('admin.user.edit-user', $user->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $user->id }})">Delete</button>
                            <form id="delete-form-{{ $user->id }}"
                                action="{{ route('admin.user.softdelete', $user->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "The user will be soft deleted and can be restored later!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        allowInput: false,
        enableTime: false,
        showMonths: 1,
        disableMobile: true,
        static: true,
        maxDate: "today"
    });

    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        allowInput: false,
        enableTime: false,
        showMonths: 1,
        disableMobile: true,
        static: true,
        maxDate: "today"
    });
});
    </script>
</body>

</html>
