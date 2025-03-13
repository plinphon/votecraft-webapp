<?php

namespace App\Http\Controllers;

use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Choice;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['choices', 'user'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|max:255',
            'detail' => 'nullable',
            'choices' => 'required|array|min:2',
            'choices.*.detail' => 'nullable|string|max:255',
            'choices.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::create([
            'topic' => $validated['topic'],
            'detail' => $validated['detail'],
            'user_id' => auth()->user()->id,
        ]);

        foreach ($request->choices as $choiceData) {
           
            $choice = new Choice([
                'post_id' => $post->id,
                'detail' => $choiceData['detail'],
            ]);
            
            if (isset($choiceData['image']) && $choiceData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $choiceData['image']->store('choice_images', 'public');
                $choice->image_path = $imagePath;
            }
            
            $choice->save();
        }

        return redirect()->route('home')
            ->with('success', 'Poll created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['choices.votes.user', 'user'])->findOrFail($id);
        
        $allVotes = collect();
        foreach ($post->choices as $choice) {
            foreach ($choice->votes as $vote) {
                // Add choice information to each vote
                $vote->choice = $choice;
                $allVotes->push($vote);
            }
        }
        $votes = $allVotes->sortByDesc('created_at');
        
        return view('posts.show', compact('post', 'votes'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::with(['choices', 'user'])->findOrFail($id);
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'topic' => 'required|max:255',
            'detail' => 'nullable',
            'choices' => 'required|array|min:2',
            'choices.*.detail' => 'required|string|max:255',
            'choices.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $post->update([
            'topic' => $validated['topic'],
            'detail' => $validated['detail'],
            'user_id' => auth()->user()->id,
        ]);
    
        // Delete existing choices
        $post->choices()->delete();
    
        // Create new choices
        foreach ($request->choices as $choiceData) {
            $choice = new Choice([
                'post_id' => $post->id,
                'detail' => $choiceData['detail'],
            ]);
            
            if (isset($choiceData['image']) && $choiceData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $choiceData['image']->store('choice_images', 'public');
                $choice->image_path = $imagePath;
            }
            
            $choice->save();
        }
    
        return redirect()->route('home')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    { 
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('home')
            ->with('success', 'Post deleted successfully.');
    }
}
