{{-- resources/views/admin/subjects/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="header-container">
    <h1>Edit Subject: {{ $subject->name }}</h1>
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i> Back to Subjects
    </a>
</div>

<div class="card">
    <div class="card-header">
        Subject Information
    </div>
    <div class="card-body">
        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $subject->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Science" {{ old('category', $subject->category) == 'Science' ? 'selected' : '' }}>Science</option>
                        <option value="Mathematics" {{ old('category', $subject->category) == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                        <option value="Languages" {{ old('category', $subject->category) == 'Languages' ? 'selected' : '' }}>Languages</option>
                        <option value="Social Studies" {{ old('category', $subject->category) == 'Social Studies' ? 'selected' : '' }}>Social Studies</option>
                        <option value="Special" {{ old('category', $subject->category) == 'Special' ? 'selected' : '' }}>Special</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $subject->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="icon" class="form-label">Subject Icon</label>
                    @if($subject->icon)
                        <div class="mb-2">
                            <img src="{{ asset('storage/subjects/' . $subject->icon) }}" alt="{{ $subject->name }}" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                    <small class="text-muted">Leave empty to keep current icon</small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="color_code" class="form-label">Color Theme</label>
                    <input type="color" class="form-control form-control-color @error('color_code') is-invalid @enderror" id="color_code" name="color_code" value="{{ old('color_code', $subject->color_code ?? '#5af7ff') }}">
                    @error('color_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $subject->display_order) }}" min="0">
                    <small class="text-muted">Lower numbers appear first</small>
                    @error('display_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <div class="mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $subject->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible to students)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-end">
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Update Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection