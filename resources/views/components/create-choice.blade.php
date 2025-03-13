@props(['index' => 0])

<div class="input-group">
    <input 
        type="text" 
        class="form-control" 
        name="choices[{{ $index }}][detail]" 
        placeholder="Enter choice" 
        required
    >
    <input
        type="file"
        class="form-control"
        name="choices[{{ $index }}][image]" 
        accept="image/*"
    >
    <button 
        type="button" 
        class="btn btn-danger remove-choice"
    >
        Remove
    </button>
</div>
<small class="form-text text-muted mb-2">Add an optional image for this choice</small>