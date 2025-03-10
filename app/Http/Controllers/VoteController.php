<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Choice;
use App\Models\Vote;

class VoteController extends Controller
{
    public function create()
    {
        return view('votes.create');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'choice_id' => 'required|exists:choices,id',
            'comment' => 'nullable'
        ]);

        Vote::create($validated);

        return redirect()->route('posts.index')
            ->with('success','Voted successfully.');
    }

    
}