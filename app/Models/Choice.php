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
        return $this->belongTo(Post::class);
    }

}
