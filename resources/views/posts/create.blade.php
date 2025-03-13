@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Poll</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <div class="form-group mb-3">
                            <label for="topic">Poll Topic</label>
                            <input 
                                type="text" 
                                class="form-control @error('topic') is-invalid @enderror" 
                                id="topic" 
                                name="topic" 
                                value="{{ old('topic') }}" 
                                required 
                                placeholder="Enter your poll topic"
                            >
                            @error('topic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="detail">Description (Optional)</label>
                            <textarea 
                                class="form-control" 
                                id="detail" 
                                name="detail" 
                                rows="3" 
                                placeholder="Provide additional details about your poll"
                            >{{ old('detail') }}</textarea>
                        </div>

                        <div id="choices-container">
                            <div class="form-group mb-3">
                                <label>Poll Choices</label>
                                
                                <div class="choice-group mb-3">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="choices[0][detail]" 
                                            placeholder="Enter choice" 
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            name="choices[0][image]" 
                                            accept="image/*"
                                        >
                                        <button 
                                            type="button" 
                                            class="btn btn-danger remove-choice"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="choice-group mb-3">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="choices[1][detail]" 
                                            placeholder="Enter choice" 
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            name="choices[1][image]" 
                                            accept="image/*"
                                        >
                                        <button 
                                            type="button" 
                                            class="btn btn-danger remove-choice"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <button 
                                type="button" 
                                id="add-choice" 
                                class="btn btn-secondary"
                            >
                                Add Another Choice
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Create Poll
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary ms-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const choicesContainer = document.querySelector('#choices-container .form-group');
    const addChoiceButton = document.getElementById('add-choice');
    let choiceIndex = 2; // Start from 2 since we already have choices[0] and choices[1]

    // Add choice functionality
    addChoiceButton.addEventListener('click', function() {
        const newChoiceGroup = document.createElement('div');
        newChoiceGroup.className = 'choice-group mb-3';
        newChoiceGroup.innerHTML = `
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control" 
                    name="choices[${choiceIndex}][detail]" 
                    placeholder="Enter choice" 
                >
                <input
                    type="file"
                    class="form-control"
                    name="choices[${choiceIndex}][image]" 
                    accept="image/*"
                >
                <button 
                    type="button" 
                    class="btn btn-danger remove-choice"
                >
                    Remove
                </button>
            </div>
        `;
        
        choicesContainer.appendChild(newChoiceGroup);
        choiceIndex++;
        updateRemoveButtons();
    });

    // Remove choice functionality
    function updateRemoveButtons() {
        const choiceGroups = document.querySelectorAll('.choice-group');
        choiceGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-choice');
            
            if (choiceGroups.length > 2) {
                removeButton.style.display = 'block';
            } else {
                removeButton.style.display = 'none';
            }

            removeButton.onclick = function() {
                group.remove();
                updateRemoveButtons();
            
            };
        });
    }

    // Initial setup of remove buttons
    updateRemoveButtons();
});
</script>
@endsection