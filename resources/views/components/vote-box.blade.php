<div class="vote-box card mt-3">
    <div class="card-body">
        @can('vote', $post)
            <form action="{{ route('votes.store', $post) }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label class="fw-bold mb-2">Choose an option:</label>
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
                                                   required>
                                            <label class="form-check-label" for="choice_{{ $choice->id }}">
                                                {{ $choice->detail }}
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
                                
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <div class="form-floating">
                        <textarea class="form-control" 
                                  id="comment" 
                                  name="comment" 
                                  rows="2"
                                  placeholder="Add a comment (optional)"
                                  style="height: 80px"></textarea>
                        <label for="comment">Comment (optional)</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <small class="text-muted">
                        Total votes: {{ \App\Http\Controllers\VoteController::getTotalVotes($choice) }}
                    </small>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check2-circle me-2"></i>Submit Vote
                    </button>
                </div>
            </form>
            @else
            <div class="voting-results">
                <div class="mb-3">
                    <label class="fw-bold mb-2 text-muted">Poll Results:</label>
                    @foreach($post->choices as $choice)
                        <div class="choice-item card mb-2 bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1 me-3">
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted me-2">
                                                @if($post->user_id === auth()->id())
                                                    <i class="bi bi-lock-fill"></i>
                                                @else
                                                    <i class="bi bi-check2"></i>
                                                @endif
                                            </span>
                                            <span class="fw-medium">{{ $choice->detail }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($choice->image_path)
                                        <img src="{{ asset('storage/' . $choice->image_path) }}" 
                                             alt="Choice Image" 
                                             class="img-thumbnail ms-3 opacity-75" 
                                             style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    @endif
                                </div>
                                
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>{{ \App\Http\Controllers\VoteController::getPercentage($choice) }}%</span>
                                        <span>{{ \App\Http\Controllers\VoteController::getTotalChoiceVotes($choice) }} votes</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-secondary" 
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

                <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                    <small class="text-muted">
                        Total votes: {{ \App\Http\Controllers\VoteController::getTotalVotes($choice) }}
                    </small>
                    <div class="text-muted">
                        @auth
                            @if($post->user_id === auth()->id())
                                <i class="bi bi-info-circle me-1"></i>Your poll
                            @else
                                <i class="bi bi-check2-circle me-1"></i>Vote recorded
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-box-arrow-in-right"></i> Login to vote
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>