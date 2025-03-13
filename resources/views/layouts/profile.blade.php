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
                        <li class="nav-item"><a href="#" class="nav-link active">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-6">
            <!-- Profile Header -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="m-0">My Polls</h5>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4">New Poll</a>
                    </div>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- User's Post Feed -->
            @forelse ($posts as $post)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                {{ substr(auth()->user()->id, 0, 1) }}
                            </div>
                            <div class="ms-3">
                                <h6 class="m-0 fw-bold">{{ auth()->user()->username }}</h6>
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
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                        <p class="mt-3">You haven't created any polls yet</p>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill px-4 mt-2">Create Your First Poll</a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Right Sidebar - Stats -->
        <div class="col-md-3 d-none d-md-block">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Your Stats</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Polls:</span>
                        <span class="fw-bold">{{ $posts->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Votes Received:</span>
                        <span class="fw-bold">{{ $posts->sum(function($post) { return $post->choices->sum(function($choice) { return $choice->votes->count(); }); }) }}</span>
                    </div>
                </div>
            </div>
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
        background-color: #1DA1F2;
        border-color: #1DA1F2;
    }
    .btn-primary:hover {
        background-color: #0d8ecf;
        border-color: #0d8ecf;
    }
    .text-primary {
        color: #1DA1F2 !important;
    }
</style>
@endsection