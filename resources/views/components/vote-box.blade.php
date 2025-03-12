<div class="vote-box card mt-3">
    <div class="card-body">
        <form method="POST" action="{{ route('votes.store') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            
            <div class="form-group mb-3">
                <label>Choose an option:</label>
                @foreach($post->choices as $choice)
                    <div class="form-check mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <input class="form-check-input" type="radio" name="choice_id" value="{{ $choice->id }}" id="choice_{{ $choice->id }}">
                                <label class="form-check-label" for="choice_{{ $choice->id }}">
                                    {{ $choice->detail }}
                                </label>
                            </div>
                            <span class="badge bg-secondary">{{ \App\Http\Controllers\VoteController::getPercentage($choice) }}% ({{ \App\Http\Controllers\VoteController::getTotalChoiceVotes($choice) }})</span>
                        </div>
                        <div class="progress mt-1" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ \App\Http\Controllers\VoteController::getPercentage($choice) }}%" 
                                aria-valuenow="{{ \App\Http\Controllers\VoteController::getPercentage($choice) }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-2 text-muted small">
                Total votes: {{ \App\Http\Controllers\VoteController::getTotalVotes($choice) }}
            </div>
            
            <div class="form-group mb-3 mt-3">
                <label for="comment">Comment (optional)</label>
                <textarea class="form-control" id="comment" name="comment" rows="2"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Vote</button>
        </form>
    </div>
</div>