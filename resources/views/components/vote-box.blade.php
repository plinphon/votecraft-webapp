<div class="vote-box card mt-3">
    <div class="card-body">
        <form method="POST" action="{{ route('votes.store') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            
            <div class="form-group mb-3">
                <label>Choose an option:</label>
                @foreach($post->choices as $choice)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="choice_id" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                        <label class="form-check-label" for="choice_{{ $choice->id }}">
                            {{ $choice->detail }}
                        </label>
                    </div>
                @endforeach
            </div>
            
            <div class="form-group mb-3">
                <label for="comment">Comment (optional)</label>
                <textarea class="form-control" id="comment" name="comment" rows="2"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Vote</button>
        </form>
    </div>
</div>