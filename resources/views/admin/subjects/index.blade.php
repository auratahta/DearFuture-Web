@extends('layouts.admin')

@section('content')
<div class="header-container">
    <h1>Manage Subjects</h1>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i> Add New Subject
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Search and View Toggle -->
<div class="search-container">
    <div class="search-bar">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="form-control" id="searchInput" placeholder="Search subjects...">
    </div>
    
    <div class="view-toggle">
        <button class="btn active" id="tableViewBtn">
            <i class="fas fa-list"></i> Table View
        </button>
        <button class="btn" id="gridViewBtn">
            <i class="fas fa-th-large"></i> Grid View
        </button>
    </div>
</div>

<!-- Table View (Default) -->
<div id="tableView" class="card">
    <div class="card-header">
        All Subjects ({{ $subjects->count() }})
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">Icon</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Display Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr class="subject-row">
                        <td>
                            <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/default-subject.png') }}" alt="{{ $subject->name }}" class="subject-icon">
                        </td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->category }}</td>
                        <td>{{ $subject->display_order }}</td>
                        <td>
                            <form action="{{ route('admin.subjects.toggle-active', $subject->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $subject->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.subjects.show', $subject->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal{{ $subject->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No subjects found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Grid View (Hidden by Default) -->
<div id="gridView" class="subject-grid" style="display: none;">
    @forelse($subjects as $subject)
    <div class="subject-card">
        <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/default-subject.png') }}" alt="{{ $subject->name }}">
        <h3>{{ $subject->name }}</h3>
        <p>{{ $subject->category }}</p>
        <p>Display Order: {{ $subject->display_order }}</p>
        
        <span class="badge {{ $subject->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
            {{ $subject->is_active ? 'Active' : 'Inactive' }}
        </span>
        
        <div class="action-buttons">
            <a href="{{ route('admin.subjects.show', $subject->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal{{ $subject->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-4">
        <p>No subjects found</p>
    </div>
    @endforelse
</div>

<!-- Delete Subject Modals -->
@foreach($subjects as $subject)
<div class="modal fade" id="deleteSubjectModal{{ $subject->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the subject <strong>{{ $subject->name }}</strong>?</p>
                <p class="text-danger">This action cannot be undone. All related data will also be deleted.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
    // Handle view toggling
    document.addEventListener('DOMContentLoaded', function() {
        const tableViewBtn = document.getElementById('tableViewBtn');
        const gridViewBtn = document.getElementById('gridViewBtn');
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');
        
        tableViewBtn.addEventListener('click', function() {
            tableView.style.display = 'block';
            gridView.style.display = 'none';
            tableViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
        });
        
        gridViewBtn.addEventListener('click', function() {
            tableView.style.display = 'none';
            gridView.style.display = 'grid';
            gridViewBtn.classList.add('active');
            tableViewBtn.classList.remove('active');
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Filter table rows
            const tableRows = document.querySelectorAll('#tableView tbody tr.subject-row');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
            
            // Filter grid cards
            const gridCards = document.querySelectorAll('#gridView .subject-card');
            gridCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endsection