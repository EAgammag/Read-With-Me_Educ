<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sentence;
use Illuminate\Http\Request;

class SentenceController extends Controller
{
    public function index(Request $request)
    {
        $query = Sentence::query();

        if ($request->filled('search')) {
            $query->where('sentence', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $sentences = $query->orderBy('difficulty')->orderBy('id')->paginate(15);
        $categories = Sentence::distinct()->pluck('category')->filter();

        return view('admin.sentences.index', compact('sentences', 'categories'));
    }

    public function create()
    {
        $categories = Sentence::distinct()->pluck('category')->filter();
        return view('admin.sentences.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sentence' => 'required|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        Sentence::create($validated);

        return redirect()->route('admin.sentences.index')
            ->with('success', 'Sentence created successfully!');
    }

    public function edit(Sentence $sentence)
    {
        $categories = Sentence::distinct()->pluck('category')->filter();
        return view('admin.sentences.edit', compact('sentence', 'categories'));
    }

    public function update(Request $request, Sentence $sentence)
    {
        $validated = $request->validate([
            'sentence' => 'required|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        $sentence->update($validated);

        return redirect()->route('admin.sentences.index')
            ->with('success', 'Sentence updated successfully!');
    }

    public function destroy(Sentence $sentence)
    {
        $sentence->delete();

        return redirect()->route('admin.sentences.index')
            ->with('success', 'Sentence deleted successfully!');
    }
}
