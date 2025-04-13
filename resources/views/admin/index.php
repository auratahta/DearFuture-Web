<!-- resources/views/admin/users/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - DearFuture</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Sama seperti style di dashboard.blade.php */
        /* ... (copy style dari template dashboard) ... */
    </style>
</head>

<body>
    <!-- Sidebar (sama seperti di dashboard) -->
    <div class="sidebar">
        <!-- ... (copy sidebar dari template dashboard) ... -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-light">Users Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users.index') }}" method="GET" class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="role" class="form-label">Filter by Role</label>
                        <select name="role" id="role" class="form-select bg-dark text-light border-dark" onchange="this.form.submit()">
                            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Users</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                            <option value="mentor" {{ request('role') == 'mentor' ? 'selected' : '' }}>Mentors</option>
                            <option value="pelajar" {{ request('role') == 'pelajar' ? 'selected' : '' }}>Students</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <div>Users List</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->profile && $user->profile->photo ? asset('storage/' . $user->profile->photo) : 'https://via.placeholder.com/40' }}" alt="User" class="user-avatar">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role == 'mentor')
                                        <span class="badge bg-info">Mentor</span>
                                    @else
                                        <span class="badge bg-success">Student</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
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
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>