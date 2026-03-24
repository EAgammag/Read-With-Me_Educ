<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryQuestion;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Story::withCount('questions');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $stories = $query->orderBy('difficulty')->orderBy('title')->paginate(15);

        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        return view('admin.stories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_emoji' => 'nullable|string|max:10',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        $story = Story::create($validated);

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'Story created! Now add some questions.');
    }

    public function edit(Story $story)
    {
        $story->load('questions');
        return view('admin.stories.edit', compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_emoji' => 'nullable|string|max:10',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        $story->update($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story updated successfully!');
    }

    public function destroy(Story $story)
    {
        // Delete related questions first
        $story->questions()->delete();
        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story deleted successfully!');
    }

    // Question Management
    public function storeQuestion(Request $request, Story $story)
    {
        // Filter out empty options
        $options = array_values(array_filter($request->options, fn($opt) => !empty(trim($opt))));
        
        $request->merge(['options' => $options]);

        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string',
            'correct_answer' => 'required|integer|min:0|max:3',
        ]);

        $maxOrder = $story->questions()->max('order') ?? 0;

        $story->questions()->create([
            'question' => $validated['question'],
            'options' => $validated['options'],
            'correct_answer' => $validated['correct_answer'],
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'Question added successfully!');
    }

    public function updateQuestion(Request $request, Story $story, StoryQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string',
            'correct_answer' => 'required|integer|min:0|max:3',
        ]);

        $question->update([
            'question' => $validated['question'],
            'options' => $validated['options'],
            'correct_answer' => $validated['correct_answer'],
        ]);

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'Question updated successfully!');
    }

    public function destroyQuestion(Story $story, StoryQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'Question deleted successfully!');
    }
}
