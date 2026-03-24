<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WordController as AdminWordController;
use App\Http\Controllers\Admin\PhraseController as AdminPhraseController;
use App\Http\Controllers\Admin\SentenceController as AdminSentenceController;
use App\Http\Controllers\Admin\StoryController as AdminStoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Redirect based on user role
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Speech transcription
    Route::post('/speech/transcribe', [SpeechController::class, 'transcribe'])->name('speech.transcribe');

    Route::get('/words', [WordController::class, 'index'])->name('words.index');
    Route::get('/words/{word}', [WordController::class, 'show'])->name('words.show');

    // User Dashboard
    Route::get('/my-progress', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/progress/record', [UserDashboardController::class, 'recordProgress'])->name('user.recordProgress');

    // Levels Routes
    Route::get('/levels', [LevelController::class, 'index'])->name('levels.index');
    
    // Level 1: Words
    Route::get('/levels/words', [LevelController::class, 'words'])->name('levels.words');
    Route::get('/levels/words/{id}/practice', [LevelController::class, 'practiceWord'])->name('levels.words.practice');
    Route::post('/levels/words/{id}/complete', [LevelController::class, 'completeWord'])->name('levels.words.complete');
    
    // Level 2: Phrases
    Route::get('/levels/phrases', [LevelController::class, 'phrases'])->name('levels.phrases');
    Route::get('/levels/phrases/{id}/practice', [LevelController::class, 'practicePhrase'])->name('levels.phrases.practice');
    Route::post('/levels/phrases/{id}/complete', [LevelController::class, 'completePhrase'])->name('levels.phrases.complete');
    
    // Level 3: Sentences
    Route::get('/levels/sentences', [LevelController::class, 'sentences'])->name('levels.sentences');
    Route::get('/levels/sentences/{id}/practice', [LevelController::class, 'practiceSentence'])->name('levels.sentences.practice');
    Route::post('/levels/sentences/{id}/complete', [LevelController::class, 'completeSentence'])->name('levels.sentences.complete');
    
    // Level 4: Stories
    Route::get('/levels/stories', [LevelController::class, 'stories'])->name('levels.stories');
    Route::get('/levels/stories/{id}/read', [LevelController::class, 'readStory'])->name('levels.stories.read');
    Route::post('/levels/stories/{id}/complete', [LevelController::class, 'completeStory'])->name('levels.stories.complete');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/level', [AdminUserController::class, 'updateLevel'])->name('users.updateLevel');

    // Words Management
    Route::get('/words', [AdminWordController::class, 'index'])->name('words.index');
    Route::get('/words/create', [AdminWordController::class, 'create'])->name('words.create');
    Route::post('/words', [AdminWordController::class, 'store'])->name('words.store');
    Route::get('/words/{word}/edit', [AdminWordController::class, 'edit'])->name('words.edit');
    Route::put('/words/{word}', [AdminWordController::class, 'update'])->name('words.update');
    Route::delete('/words/{word}', [AdminWordController::class, 'destroy'])->name('words.destroy');

    // Phrases Management
    Route::get('/phrases', [AdminPhraseController::class, 'index'])->name('phrases.index');
    Route::get('/phrases/create', [AdminPhraseController::class, 'create'])->name('phrases.create');
    Route::post('/phrases', [AdminPhraseController::class, 'store'])->name('phrases.store');
    Route::get('/phrases/{phrase}/edit', [AdminPhraseController::class, 'edit'])->name('phrases.edit');
    Route::put('/phrases/{phrase}', [AdminPhraseController::class, 'update'])->name('phrases.update');
    Route::delete('/phrases/{phrase}', [AdminPhraseController::class, 'destroy'])->name('phrases.destroy');

    // Sentences Management
    Route::get('/sentences', [AdminSentenceController::class, 'index'])->name('sentences.index');
    Route::get('/sentences/create', [AdminSentenceController::class, 'create'])->name('sentences.create');
    Route::post('/sentences', [AdminSentenceController::class, 'store'])->name('sentences.store');
    Route::get('/sentences/{sentence}/edit', [AdminSentenceController::class, 'edit'])->name('sentences.edit');
    Route::put('/sentences/{sentence}', [AdminSentenceController::class, 'update'])->name('sentences.update');
    Route::delete('/sentences/{sentence}', [AdminSentenceController::class, 'destroy'])->name('sentences.destroy');

    // Stories Management
    Route::get('/stories', [AdminStoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/create', [AdminStoryController::class, 'create'])->name('stories.create');
    Route::post('/stories', [AdminStoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{story}/edit', [AdminStoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{story}', [AdminStoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [AdminStoryController::class, 'destroy'])->name('stories.destroy');
    
    // Story Questions
    Route::post('/stories/{story}/questions', [AdminStoryController::class, 'storeQuestion'])->name('stories.questions.store');
    Route::put('/stories/{story}/questions/{question}', [AdminStoryController::class, 'updateQuestion'])->name('stories.questions.update');
    Route::delete('/stories/{story}/questions/{question}', [AdminStoryController::class, 'destroyQuestion'])->name('stories.questions.destroy');
});

require __DIR__.'/auth.php';
