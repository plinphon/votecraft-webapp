<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Choice;
use App\Models\Vote;

class VoteController extends Controller
{

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'choice_id' => 'required|exists:choices,id',
            'comment' => 'nullable'
        ]);

        Vote::create($validated);

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