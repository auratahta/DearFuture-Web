{{-- resources/views/admin/subjects/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="header-container">
    <h1>Add New Subject</h1>
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-2"></i> Back to Subjects
    </a>
</div>

<div class="card">
    <div class="card-header">
        Subject Information
    </div>
    <div class="card-body">
        <form action="{{ route('admin.subjects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Science" {{ old('category') == 'Science' ? 'selected' : '' }}>Science</option>
                        <option value="Mathematics" {{ old('category') == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                        <option value="Languages" {{ old('category') == 'Languages' ? 'selected' : '' }}>Languages</option>
                        <option value="Social Studies" {{ old('category') == 'Social Studies' ? 'selected' : '' }}>Social Studies</option>
                        <option value="Special" {{ old('category') == 'Special' ? 'selected' : '' }}>Special</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="icon" class="form-label">Subject Icon</label>
                    <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                    <small class="text-muted">Recommended size: 200x200px, max 2MB</small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="color_code" class="form-label">Color Theme</label>
                    <input type="color" class="form-control form-control-color @error('color_code') is-invalid @enderror" id="color_code" name="color_code" value="{{ old('color_code', '#5af7ff') }}">
                    @error('color_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0">
                    <small class="text-muted">Lower numbers appear first</small>
                    @error('display_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <div class="mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
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
                    <i class="fas fa-save me-2"></i> Save Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection