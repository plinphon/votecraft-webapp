@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h2>{{ $post->topic }}</h2>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
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
        </div>
    </div>
</div>
@endsection