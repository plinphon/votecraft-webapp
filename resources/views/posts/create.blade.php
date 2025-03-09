@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h2>Create New Poll</h2>
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

                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="topic">Topic</label>
                            <input type="text" class="form-control" id="topic" name="topic" value="{{ old('topic') }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="detail">Detail</label>
                            <textarea class="form-control" id="detail" name="detail" rows="5" required>{{ old('detail') }}</textarea>
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        
                        <div class="form-group mb-3">
                            <label>Poll Choices</label>
                            <div id="choice-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="choice[]" placeholder="Choice 1" required>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="choice[]" placeholder="Choice 2" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="add-choice">+ Add Another Choice</button>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create Poll</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addChoiceBtn = document.getElementById('add-choice');
    const choiceContainer = document.getElementById('choice-container');
    let choiceCount = 2;
    
    addChoiceBtn.addEventListener('click', function() {
        choiceCount++;
        const newChoice = document.createElement('div');
        newChoice.className = 'input-group mb-2';
        newChoice.innerHTML = `
            <input type="text" class="form-control" name="choice[]" placeholder="Choice ${choiceCount}" required>
            <button class="btn btn-outline-danger remove-choice" type="button">Remove</button>
        `;
        choiceContainer.appendChild(newChoice);
        
        // Add event listener to the remove button
        newChoice.querySelector('.remove-choice').addEventListener('click', function() {
            choiceContainer.removeChild(newChoice);
        });
    });
});
</script>
@endsection