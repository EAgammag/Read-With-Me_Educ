<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Word;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get accurate statistics from database
        $stats = [
            'total_users' => User::where('is_admin', false)->count(),
            'total_words' => Word::count(),
            'total_practice_sessions' => UserProgress::sum('attempts'), // Total attempts across all records
            'words_mastered' => UserProgress::where('mastered', true)->count(),
        ];

        // Get recent activity with user and word details
        $recentActivity = UserProgress::with(['user', 'word'])
            ->whereHas('user', function($query) {
                $query->where('is_admin', false);
            })
            ->latest('updated_at')
            ->take(10)
            ->get();

        // Get top performers based on mastered words
        $topPerformers = User::where('is_admin', false)
            ->withCount(['progress', 'masteredWords'])
            ->orderByDesc('mastered_words_count')
            ->orderByDesc('progress_count')
            ->take(5)
            ->get();

        // Get level distribution
        $levelDistribution = User::where('is_admin', false)
            ->select('level', DB::raw('count(*) as count'))
            ->groupBy('level')
            ->orderBy('level')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActivity', 'topPerformers', 'levelDistribution'));
    }
}
