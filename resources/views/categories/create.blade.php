@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-primary mb-4">Add Category</h2>

    {{-- Popup message for duplicate name --}}
    @if ($errors->any())
        <script>
            alert("{{ $errors->first() }}");
        </script>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">
            Save Category
        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>
</div>
@endsection