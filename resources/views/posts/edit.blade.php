@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h2>Edit Post</h2>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('posts.update', $post) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="topic">Topic</label>
                            <input type="text" class="form-control" id="topic" name="topic" value="{{ old('topic', $post->topic) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="user_id">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" value="{{ old('user_id', $post->user_id) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="detail">Detail</label>
                            <textarea class="form-control" id="detail" name="detail" rows="5" required>{{ old('detail', $post->detail) }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection