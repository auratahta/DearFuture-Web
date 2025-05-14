{{-- resources/views/admin/subjects/mentors.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="header-container">
    <h1>Manage Mentors for: {{ $subject->name }}</h1>
    <div>
        <a href="{{ route('admin.subjects.show', $subject->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Back to Subject
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Current Mentors ({{ $subject->mentors->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subject->mentors as $mentor)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $mentor->photo ? asset('storage/' . $mentor->photo) : asset('image/profile.png') }}" alt="{{ $mentor->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            {{ $mentor->name }}
                                        </div>
                                    </td>
                                    <td>{{ $mentor->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.subjects.remove-mentor', ['subject' => $subject->id, 'mentor' => $mentor->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this mentor?');">
                                                <i class="fas fa-user-minus me-1"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3">No mentors assigned to this subject</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add Mentors</h5>
            </div>
            <div class="card-body">
                @if($availableMentors->count() > 0)
                    <form action="{{ route('admin.subjects.add-mentor', $subject->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="mentor_id" class="form-label">Select Mentor</label>
                            <select class="form-select @error('mentor_id') is-invalid @enderror" id="mentor_id" name="mentor_id" required>
                                <option value="">Choose a mentor...</option>
                                @foreach($availableMentors as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})</option>
                                @endforeach
                            </select>
                            @error('mentor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Add Mentor
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info mb-0">
                        All available mentors have already been assigned to this subject.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection