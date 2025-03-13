{{-- resources/views/components/post-votes.blade.php --}}

<div class="post-votes mt-4">
    <h3>Votes</h3>
    
    @forelse ($votes as $vote)
        <div class="vote card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $vote->user->username ?? 'Unknown User' }}</h5>
                    <small class="text-muted">{{ $vote->created_at->diffForHumans() }}</small>
                </div>
                <p class="card-text mt-2">
                    Voted for: <strong>{{ $vote->choice->detail }}</strong>
                    @if(isset($vote->comment) && !empty($vote->comment))
                        <br>{{ $vote->comment }}
                    @endif
                </p>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No votes yet. Be the first to vote!</div>
    @endforelse
</div>