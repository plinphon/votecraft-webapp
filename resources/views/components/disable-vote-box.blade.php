<div class="vote-box card mt-3">
    <div class="card-body">
        <div class="mb-3">
            <label class="fw-bold mb-2">Poll Results:</label>
            @foreach($post->choices as $choice)
                <div class="choice-item card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1 me-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                           name="choice_id" 
                                           value="{{ $choice->id }}" 
                                           id="choice_{{ $choice->id }}"
                                           disabled
                                           {{ $userVote && $userVote->choice_id == $choice->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="choice_{{ $choice->id }}">
                                        {{ $choice->detail }}
                                        @if($userVote && $userVote->choice_id == $choice->id)
                                            <span class="badge bg-primary ms-2">Your Vote</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            
                            @if($choice->image_path)
                                <img src="{{ asset('storage/' . $choice->image_path) }}" 
                                     alt="Choice Image" 
                                     class="img-thumbnail ms-3" 
                                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            @endif
                        </div>
                        
                        <div class="mt-2">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>{{ \App\Http\Controllers\VoteController::getPercentage($choice) }}%</span>
                                <span>{{ \App\Http\Controllers\VoteController::getTotalChoiceVotes($choice) }} votes</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" 
                                     role="progressbar" 
                                     style="width: {{ \App\Http\Controllers\VoteController::getPercentage($choice) }}%" 
                                     aria-valuenow="{{ \App\Http\Controllers\VoteController::getPercentage($choice) }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">
                Total votes: {{ \App\Http\Controllers\VoteController::getTotalVotes($choice) }}
            </small>
            <div class="alert alert-info mb-0 py-2">
                <i class="bi bi-info-circle me-2"></i>
                @if($post->user_id === auth()->id())
                    You cannot vote on your own poll
                @else
                    You've already voted on this poll
                @endif
            </div>
        </div>
        
        @if($userVote && $userVote->comment)
            <div class="mt-4 pt-3 border-top">
                <h6 class="fw-bold">Your Comment:</h6>
                <p class="mb-0">{{ $userVote->comment }}</p>
            </div>
        @endif
    </div>
</div>