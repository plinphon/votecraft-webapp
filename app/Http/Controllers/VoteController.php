<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Choice;
use App\Models\Vote;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{

    public function store(Request $request, Post $post) 
    {
        $this->authorize('vote', $post); 
    
        $validated = $request->validate([
            'choice_id' => [
                'required',
                Rule::exists('choices', 'id')->where('post_id', $post->id)
            ],
            'comment' => 'nullable'
        ]);
    
        Vote::create([
            'user_id' => auth()->id(),
            'choice_id' => $validated['choice_id'],
            'comment' => $validated['comment'] ?? null
        ]);
    
        return redirect()->route('home')
            ->with('success','Voted successfully.');
    }

    public static function getTotalVotes(Choice $choice)
    {
        return $choice->post ? $choice->post->choices->sum(fn($c) => $c->votes()->count()) : 0;
    }

    public static function getTotalChoiceVotes(Choice $choice)
    {
        return $choice->post ? $choice->votes()->count() : 0;
    }

    public static function getPercentage(Choice $choice)
    { 
        $totalVotes = self::getTotalVotes($choice);
    
        if ($totalVotes === 0) {
            return 0;
        }
    
        $choiceVotes = $choice->votes()->count();
        return round(($choiceVotes / $totalVotes) * 100, 2);
    }
}