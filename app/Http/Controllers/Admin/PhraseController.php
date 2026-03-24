<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use Illuminate\Http\Request;

class PhraseController extends Controller
{
    public function index(Request $request)
    {
        $query = Phrase::query();

        if ($request->filled('search')) {
            $query->where('phrase', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $phrases = $query->orderBy('difficulty')->orderBy('phrase')->paginate(15);

        return view('admin.phrases.index', compact('phrases'));
    }

    public function create()
    {
        return view('admin.phrases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phrase' => 'required|string|max:255',
            'meaning' => 'nullable|string',
            'example_sentence' => 'nullable|string',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        Phrase::create($validated);

        return redirect()->route('admin.phrases.index')
            ->with('success', 'Phrase created successfully!');
    }

    public function edit(Phrase $phrase)
    {
        return view('admin.phrases.edit', compact('phrase'));
    }

    public function update(Request $request, Phrase $phrase)
    {
        $validated = $request->validate([
            'phrase' => 'required|string|max:255',
            'meaning' => 'nullable|string',
            'example_sentence' => 'nullable|string',
            'difficulty' => 'required|integer|min:1|max:10',
        ]);

        $phrase->update($validated);

        return redirect()->route('admin.phrases.index')
            ->with('success', 'Phrase updated successfully!');
    }

    public function destroy(Phrase $phrase)
    {
        $phrase->delete();

        return redirect()->route('admin.phrases.index')
            ->with('success', 'Phrase deleted successfully!');
    }
}
