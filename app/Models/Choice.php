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
        'image_path'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}