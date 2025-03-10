<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'votes';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'choice_id',
        'comment',
    ];

    /**
     * Get the user that owns this vote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the choice that this vote is for.
     */
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}