<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        return view('words.index', compact('words'));
    }

    public function show(Word $word)
    {
        return view('words.show', compact('word'));
    }
}
