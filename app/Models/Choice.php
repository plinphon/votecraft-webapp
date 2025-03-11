<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'choices';

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'detail',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getTotalVotes()
    {
        if (!$this->post || !$this->post->votes) {
            return 0;
        }

        return $this->post->votes->count();
    }

    public function getPercentage()
    {
        $totalVotes = $this->getTotalVotes();

        if ($totalVotes === 0) {
            return 0;
        }

        $choiceVotes = $this->votes->count();
        return round(($choiceVotes / $totalVotes) * 100, 1);
    }
}