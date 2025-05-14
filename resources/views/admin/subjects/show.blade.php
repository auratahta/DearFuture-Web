{{-- resources/views/admin/subjects/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="header-container">
    <h1>Subject Details: {{ $subject->name }}</h1>
    <div>
        <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Edit
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-primary ms-2">
            <i class="fas fa-arrow-left me-2"></i> Back
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Basic Information
            </div>
            <div class="card-body text-center">
                <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/subjects/default.png') }}" alt="{{ $subject->name }}" class="img-fluid rounded mb-3" style="max-height: 150px;">
                
                <h3>{{ $subject->name }}</h3>
                <span class="badge {{ $subject->is_active ? 'bg-success' : 'bg-danger' }} mb-3">
                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                </span>
                
                <div class="text-start mt-3">
                    <p><strong>Category:</strong> {{ $subject->category }}</p>
                    <p><strong>Display Order:</strong> {{ $subject->display_order }}</p>
                    @if($subject->color_code)
                        <p>
                            <strong>Color Theme:</strong> 
                            <span class="ms-2 px-3 py-1 rounded" style="background-color: {{ $subject->color_code }};">
                                {{ $subject->color_code }}
                            </span>
                        </p>
                    @endif
                    <p><strong>Created:</strong> {{ $subject->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $subject->updated_at->format('M d, Y') }}</p>
                </div>
                
                <form action="{{ route('admin.subjects.toggle-active', $subject->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $subject->is_active ? 'btn-danger' : 'btn-success' }} w-100">
                        <i class="fas {{ $subject->is_active ? 'fa-ban' : 'fa-check-circle' }} me-2"></i>
                        {{ $subject->is_active ? 'Deactivate Subject' : 'Activate Subject' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">Description</div>
            <div class="card-body">
                {{ $subject->description ?? 'No description available' }}
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Associated Mentors ({{ $subject->mentors->count() }})</span>
                <a href="{{ route('admin.subjects.mentors', $subject->id) }}" class="btn btn-sm btn-outline-primary">Manage Mentors</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mentor</th>
                                <th>Email</th>
                                <th>Hourly Rate</th>
                                <th>Rating</th>
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
                                    <td>{{ $mentor->mentorProfile?->hourly_rate ? 'Rp ' . number_format($mentor->mentorProfile->hourly_rate, 0, ',', '.') : 'Not set' }}</td>
                                    <td>{{ $mentor->mentorProfile?->average_rating ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">No mentors associated with this subject</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                Recent Sessions ({{ $subject->sessions ? $subject->sessions->count() : 0 }})
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Mentor</th>
                                <th>Student</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($subject->sessions ? $subject->sessions->take(5) : collect()) as $session)
                                <tr>
                                    <td>{{ $session->date->format('M d, Y') }} {{ $session->start_time->format('H:i') }}</td>
                                    <td>{{ $session->mentor->name }}</td>
                                    <td>{{ $session->student->name }}</td>
                                    <td>
                                        @if($session->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($session->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($session->status == 'confirmed')
                                            <span class="badge bg-info">Confirmed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">No sessions found for this subject</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection