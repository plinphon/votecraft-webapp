<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic',
        'user_id',
        'detail',
    ];
    
    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}