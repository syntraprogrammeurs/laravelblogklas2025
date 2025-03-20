@php use App\Models\Category; @endphp
@extends('layouts.backend')
@section('title', 'Categories')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <div class="container-fluid px-4">
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Category Management</h1>
            @can('create', Category::class)
                <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#categoryOffcanvas">
                    <i class="fas fa-plus"></i> New Category
                </button>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table me-1"></i> Category Overview</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Posts Count</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>
                                @if($category->trashed())
                                    <span class="badge bg-warning">Trashed</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if(!$category->trashed())
                                        @can('update', $category)
                                            <button type="button" 
                                                    class="btn btn-sm btn-info"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editCategoryModal{{ $category->id }}"
                                                    title="Edit Category">
                                                <i class="fas fa-edit text-white"></i>
                                            </button>
                                        @endcan
                                    @endif
                                    @if($category->trashed())
                                        @can('restore', $category)
                                            <form method="POST"
                                                  action="{{ route('categories.restore', $category->id) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm btn-success"
                                                        title="Restore Category">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('forceDelete', $category)
                                            <form method="POST"
                                                  action="{{ route('categories.forceDelete', $category->id) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Permanently Delete Category"
                                                        onclick="return confirm('Are you sure you want to permanently delete this category?');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @else
                                        @can('delete', $category)
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-warning"
                                                        title="Move to Trash"
                                                        onclick="return confirm('Are you sure you want to move this category to the trash?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Category Creation Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="categoryOffcanvas" aria-labelledby="categoryOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="categoryOffcanvasLabel">Create New Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('categories.store') }}" method="POST" x-data="{ name: '' }">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name') }}" required x-model="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modals -->
    @foreach($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_name{{ $category->id }}" class="form-label">Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="edit_name{{ $category->id }}" 
                                       name="name"
                                       value="{{ old('name', $category->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
