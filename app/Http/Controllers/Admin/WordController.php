<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Request $request)
    {
        $query = Word::query();

        if ($request->filled('search')) {
            $query->where('word', 'like', '%' . $request->search . '%');
        }

        $words = $query->orderBy('word')->paginate(15);

        return view('admin.words.index', compact('words'));
    }

    public function create()
    {
        return view('admin.words.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:255|unique:words,word',
            'phonetic_spelling' => 'nullable|string|max:255',
            'phonemes' => 'nullable|string',
            'example_sentence' => 'nullable|string',
        ]);

        // Convert phonemes string to array
        if (!empty($validated['phonemes'])) {
            $validated['phonemes'] = array_map('trim', explode(',', $validated['phonemes']));
        }

        Word::create($validated);

        return redirect()->route('admin.words.index')
            ->with('success', 'Word created successfully!');
    }

    public function edit(Word $word)
    {
        return view('admin.words.edit', compact('word'));
    }

    public function update(Request $request, Word $word)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:255|unique:words,word,' . $word->id,
            'phonetic_spelling' => 'nullable|string|max:255',
            'phonemes' => 'nullable|string',
            'example_sentence' => 'nullable|string',
        ]);

        // Convert phonemes string to array
        if (!empty($validated['phonemes'])) {
            $validated['phonemes'] = array_map('trim', explode(',', $validated['phonemes']));
        }

        $word->update($validated);

        return redirect()->route('admin.words.index')
            ->with('success', 'Word updated successfully!');
    }

    public function destroy(Word $word)
    {
        // Delete related progress first
        $word->progress()->delete();
        $word->delete();

        return redirect()->route('admin.words.index')
            ->with('success', 'Word deleted successfully!');
    }
}
