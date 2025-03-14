@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h2>{{ $post->topic }}</h2>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>Created by User ID:</strong> {{ $post->user_id }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Created at:</strong> {{ $post->created_at->format('F d, Y H:i') }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Details:</strong>
                        <p class="mt-2">{{ $post->detail }}</p>
                    </div>
                    
                    <!-- Add voting component here -->
                    @include('components.vote-box', ['post' => $post])
                    
                    <div class="d-flex mt-4">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary me-2">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Comments section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Comments</h3>
                </div>
                
                <div class="card-body">
                    @include('components.post-votes', ['post' => $post])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection