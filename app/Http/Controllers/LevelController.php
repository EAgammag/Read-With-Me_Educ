<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Phrase;
use App\Models\Sentence;
use App\Models\Story;
use App\Models\LevelProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    /**
     * Get the count of completed items for a level
     */
    private function getCompletedCount($userId, $levelNumber, $contentType)
    {
        return LevelProgress::where('user_id', $userId)
            ->where('level_number', $levelNumber)
            ->where('content_type', $contentType)
            ->where('completed', true)
            ->count();
    }

    /**
     * Check if a level is unlocked
     */
    private function isLevelUnlocked($userId, $levelNumber)
    {
        switch ($levelNumber) {
            case 1:
                return true; // Level 1 is always unlocked
            case 2:
                // Level 2 unlocks when all 30 words are completed with 100% accuracy
                $totalWords = Word::count();
                $completedWords = $this->getCompletedCount($userId, 1, 'word');
                return $completedWords >= $totalWords && $totalWords > 0;
            case 3:
                // Level 3 unlocks when all 15 phrases are completed
                $totalPhrases = Phrase::count();
                $completedPhrases = $this->getCompletedCount($userId, 2, 'phrase');
                return $this->isLevelUnlocked($userId, 2) && $completedPhrases >= $totalPhrases && $totalPhrases > 0;
            case 4:
                // Level 4 unlocks when all 15 sentences are completed
                $totalSentences = Sentence::count();
                $completedSentences = $this->getCompletedCount($userId, 3, 'sentence');
                return $this->isLevelUnlocked($userId, 3) && $completedSentences >= $totalSentences && $totalSentences > 0;
            default:
                return false;
        }
    }

    public function index()
    {
        $user = Auth::user();
        
        $wordCount = Word::count();
        $phraseCount = Phrase::count();
        $sentenceCount = Sentence::count();
        $storyCount = Story::count();

        // Get progress for each level
        $levels = [
            [
                'number' => 1,
                'title' => 'Phonetic Foundations',
                'subtitle' => 'Word Mastery',
                'description' => 'Master 30 individual words with 100% accuracy using voice recognition.',
                'emoji' => '🎯',
                'color' => 'from-pink-400 to-rose-500',
                'total' => $wordCount,
                'completed' => $this->getCompletedCount($user->id, 1, 'word'),
                'unlocked' => true,
                'requirement' => '100% accuracy required on all words',
            ],
            [
                'number' => 2,
                'title' => 'Articulation & Flow',
                'subtitle' => 'Phrase Mastery',
                'description' => 'Read 15 phrases focusing on rhythm and oral fluency.',
                'emoji' => '🔊',
                'color' => 'from-orange-400 to-amber-500',
                'total' => $phraseCount,
                'completed' => $this->getCompletedCount($user->id, 2, 'phrase'),
                'unlocked' => $this->isLevelUnlocked($user->id, 2),
                'requirement' => 'Complete all words to unlock',
            ],
            [
                'number' => 3,
                'title' => 'Syntactic Precision',
                'subtitle' => 'Sentence Mastery',
                'description' => 'Read 15 sentences with proper intonation and pacing.',
                'emoji' => '✨',
                'color' => 'from-green-400 to-emerald-500',
                'total' => $sentenceCount,
                'completed' => $this->getCompletedCount($user->id, 3, 'sentence'),
                'unlocked' => $this->isLevelUnlocked($user->id, 3),
                'requirement' => 'Complete all phrases to unlock',
            ],
            [
                'number' => 4,
                'title' => 'Cognitive Integration',
                'subtitle' => 'Reading Comprehension',
                'description' => 'Read stories and answer comprehension questions by typing.',
                'emoji' => '📖',
                'color' => 'from-purple-400 to-violet-500',
                'total' => $storyCount,
                'completed' => $this->getCompletedCount($user->id, 4, 'story'),
                'unlocked' => $this->isLevelUnlocked($user->id, 4),
                'requirement' => 'Complete all sentences to unlock',
            ],
        ];

        return view('levels.index', compact('levels'));
    }

    public function words()
    {
        $user = Auth::user();
        $words = Word::all();
        
        // Get completed word IDs
        $completedIds = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 1)
            ->where('content_type', 'word')
            ->where('completed', true)
            ->pluck('content_id')
            ->toArray();

        $totalWords = $words->count();
        $completedCount = count($completedIds);
        $allCompleted = $completedCount >= $totalWords && $totalWords > 0;

        return view('levels.words', compact('words', 'completedIds', 'totalWords', 'completedCount', 'allCompleted'));
    }

    public function practiceWord($id)
    {
        $word = Word::findOrFail($id);
        $nextWord = Word::where('id', '>', $id)->first();
        $totalWords = Word::count();
        $user = Auth::user();
        $completedCount = $this->getCompletedCount($user->id, 1, 'word');
        
        return view('levels.practice-word', compact('word', 'nextWord', 'totalWords', 'completedCount'));
    }

    public function completeWord(Request $request, $id)
    {
        $user = Auth::user();
        
        LevelProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'level_number' => 1,
                'content_type' => 'word',
                'content_id' => $id,
            ],
            [
                'completed' => true,
                'score' => $request->input('score', 100),
                'completed_at' => now(),
            ]
        );

        // Check if all words are completed
        $totalWords = Word::count();
        $completedWords = $this->getCompletedCount($user->id, 1, 'word');
        $levelCompleted = $completedWords >= $totalWords;

        // Get next level's first item for auto-redirect
        $nextLevelUrl = null;
        if ($levelCompleted) {
            $firstPhrase = Phrase::first();
            if ($firstPhrase) {
                $nextLevelUrl = route('levels.phrases.practice', $firstPhrase->id);
            }
        }

        return response()->json([
            'success' => true,
            'completed_count' => $completedWords,
            'total' => $totalWords,
            'level_completed' => $levelCompleted,
            'next_level_url' => $nextLevelUrl,
            'score' => $completedWords,
        ]);
    }

    public function phrases()
    {
        $user = Auth::user();
        
        // Check if level is unlocked
        if (!$this->isLevelUnlocked($user->id, 2)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all words in Level 1 with 100% accuracy to unlock Level 2.');
        }

        $phrases = Phrase::all();
        
        $completedIds = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 2)
            ->where('content_type', 'phrase')
            ->where('completed', true)
            ->pluck('content_id')
            ->toArray();

        $totalPhrases = $phrases->count();
        $completedCount = count($completedIds);
        $allCompleted = $completedCount >= $totalPhrases && $totalPhrases > 0;

        return view('levels.phrases', compact('phrases', 'completedIds', 'totalPhrases', 'completedCount', 'allCompleted'));
    }

    public function practicePhrase($id)
    {
        $user = Auth::user();
        
        if (!$this->isLevelUnlocked($user->id, 2)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all words in Level 1 to unlock Level 2.');
        }

        $phrase = Phrase::findOrFail($id);
        $nextPhrase = Phrase::where('id', '>', $id)->first();
        $totalPhrases = Phrase::count();
        $completedCount = $this->getCompletedCount($user->id, 2, 'phrase');
        
        return view('levels.practice-phrase', compact('phrase', 'nextPhrase', 'totalPhrases', 'completedCount'));
    }

    public function completePhrase(Request $request, $id)
    {
        $user = Auth::user();
        
        LevelProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'level_number' => 2,
                'content_type' => 'phrase',
                'content_id' => $id,
            ],
            [
                'completed' => true,
                'score' => $request->input('score', 100),
                'completed_at' => now(),
            ]
        );

        $totalPhrases = Phrase::count();
        $completedPhrases = $this->getCompletedCount($user->id, 2, 'phrase');
        $levelCompleted = $completedPhrases >= $totalPhrases;

        // Get next level's first item for auto-redirect
        $nextLevelUrl = null;
        if ($levelCompleted) {
            $firstSentence = Sentence::first();
            if ($firstSentence) {
                $nextLevelUrl = route('levels.sentences.practice', $firstSentence->id);
            }
        }

        return response()->json([
            'success' => true,
            'completed_count' => $completedPhrases,
            'total' => $totalPhrases,
            'level_completed' => $levelCompleted,
            'next_level_url' => $nextLevelUrl,
            'score' => $completedPhrases,
        ]);
    }

    public function sentences()
    {
        $user = Auth::user();
        
        if (!$this->isLevelUnlocked($user->id, 3)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all phrases in Level 2 to unlock Level 3.');
        }

        $sentences = Sentence::all();
        
        $completedIds = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 3)
            ->where('content_type', 'sentence')
            ->where('completed', true)
            ->pluck('content_id')
            ->toArray();

        $totalSentences = $sentences->count();
        $completedCount = count($completedIds);
        $allCompleted = $completedCount >= $totalSentences && $totalSentences > 0;

        return view('levels.sentences', compact('sentences', 'completedIds', 'totalSentences', 'completedCount', 'allCompleted'));
    }

    public function practiceSentence($id)
    {
        $user = Auth::user();
        
        if (!$this->isLevelUnlocked($user->id, 3)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all phrases in Level 2 to unlock Level 3.');
        }

        $sentence = Sentence::findOrFail($id);
        $nextSentence = Sentence::where('id', '>', $id)->first();
        $totalSentences = Sentence::count();
        $completedCount = $this->getCompletedCount($user->id, 3, 'sentence');
        
        return view('levels.practice-sentence', compact('sentence', 'nextSentence', 'totalSentences', 'completedCount'));
    }

    public function completeSentence(Request $request, $id)
    {
        $user = Auth::user();
        
        LevelProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'level_number' => 3,
                'content_type' => 'sentence',
                'content_id' => $id,
            ],
            [
                'completed' => true,
                'score' => $request->input('score', 100),
                'completed_at' => now(),
            ]
        );

        $totalSentences = Sentence::count();
        $completedSentences = $this->getCompletedCount($user->id, 3, 'sentence');
        $levelCompleted = $completedSentences >= $totalSentences;

        // Get next level's first item for auto-redirect
        $nextLevelUrl = null;
        if ($levelCompleted) {
            $firstStory = Story::first();
            if ($firstStory) {
                $nextLevelUrl = route('levels.stories.read', $firstStory->id);
            }
        }

        return response()->json([
            'success' => true,
            'completed_count' => $completedSentences,
            'total' => $totalSentences,
            'level_completed' => $levelCompleted,
            'next_level_url' => $nextLevelUrl,
            'score' => $completedSentences,
        ]);
    }

    public function stories()
    {
        $user = Auth::user();
        
        if (!$this->isLevelUnlocked($user->id, 4)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all sentences in Level 3 to unlock Level 4.');
        }

        $stories = Story::withCount('questions')->get();
        
        $completedIds = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 4)
            ->where('content_type', 'story')
            ->where('completed', true)
            ->pluck('content_id')
            ->toArray();

        // Get scores for completed stories
        $storyScores = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 4)
            ->where('content_type', 'story')
            ->where('completed', true)
            ->pluck('score', 'content_id')
            ->toArray();

        return view('levels.stories', compact('stories', 'completedIds', 'storyScores'));
    }

    public function readStory($id)
    {
        $user = Auth::user();
        
        if (!$this->isLevelUnlocked($user->id, 4)) {
            return redirect()->route('levels.index')
                ->with('error', 'Complete all sentences in Level 3 to unlock Level 4.');
        }

        $story = Story::with('questions')->findOrFail($id);
        return view('levels.read-story', compact('story'));
    }

    public function completeStory(Request $request, $id)
    {
        $user = Auth::user();
        
        LevelProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'level_number' => 4,
                'content_type' => 'story',
                'content_id' => $id,
            ],
            [
                'completed' => true,
                'score' => $request->input('score', 0),
                'completed_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }
}
