@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-md-3 d-none d-md-block">
            <div class="card mb-3">
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="{{ route('profile') }}" class="nav-link">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-6">
            <!-- Create Post Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="m-0">Create a poll</h5>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4">New Poll</a>
                    </div>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Post Feed -->
            @forelse ($posts as $post)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                {{ substr($post->user_id, 0, 1) }}
                            </div>
                            <div class="ms-3">
                                <h6 class="m-0 fw-bold">{{ $post->user->username }}</h6>
                                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->topic }}</h5>
                        <p class="card-text">{{ $post->detail }}</p>
                    </div>
                    
                    <!-- Vote Section -->
                    <div class="card-footer bg-white border-top-0">
                        @include('components.vote-box', ['post' => $post])
                        
                        <div class="d-flex justify-content-around mt-3 pt-3 border-top">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-link text-decoration-none text-secondary">
                                <i class="bi bi-chat-dots"></i> Comments
                            </a>
                            
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-link text-decoration-none text-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-decoration-none text-secondary" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                        <p class="mt-3">No posts found</p>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Create Your First Post</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
<style>
    .card {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.125);
    }
    .btn-primary {
        background-color: #FF8C00;
        border-color: #FF8C00;
    }
    .btn-primary:hover {
        background-color: #E67E00;
        border-color: #E67E00;
    }
    .text-primary {
        color: #FF8C00 !important;
    }
    .bg-primary {
        background-color: #FF8C00 !important;
    }
    .border-primary {
        border-color: #FF8C00 !important;
    }
    /* Additional orange theme elements */
    a {
        color: #FF8C00;
    }
    a:hover {
        color: #E67E00;
    }
    .nav-link.active {
        color: #FF8C00 !important;
        font-weight: bold;
    }
    .form-check-input:checked {
        background-color: #FF8C00;
        border-color: #FF8C00;
    }
</style>
@endsection
