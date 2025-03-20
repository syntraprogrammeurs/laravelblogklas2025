@php use App\Models\Comment; @endphp
@extends('layouts.backend')
@section('title', 'Edit Comment')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('comments.index') }}">Comments</a></li>
    <li class="breadcrumb-item active">Edit Comment</li>
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i> Edit Comment
            </div>
            <div class="card-body">
                <form action="{{ route('comments.update', $comment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="body" class="form-label">Comment</label>
                        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="5">{{ old('body', $comment->body) }}</textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Post</label>
                        <p class="form-control-static">
                            <a href="{{ route('frontend.post.show', $comment->post->slug) }}" target="_blank">
                                {{ $comment->post->title }}
                            </a>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <p class="form-control-static">{{ $comment->user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Created At</label>
                        <p class="form-control-static">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Comment</button>
                        <a href="{{ route('comments.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 