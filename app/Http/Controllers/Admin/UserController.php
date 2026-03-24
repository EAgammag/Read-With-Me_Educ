<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_admin', false)
            ->withCount(['progress', 'masteredWords']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('level')) {
            $query->where('level', $request->get('level'));
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['progress.word']);
        
        $progressStats = [
            'total_attempts' => $user->progress->sum('attempts'),
            'correct_attempts' => $user->progress->sum('correct_attempts'),
            'words_practiced' => $user->progress->count(),
            'words_mastered' => $user->progress->where('mastered', true)->count(),
        ];

        $progressStats['accuracy'] = $progressStats['total_attempts'] > 0 
            ? round(($progressStats['correct_attempts'] / $progressStats['total_attempts']) * 100) 
            : 0;

        $wordProgress = $user->progress()->with('word')->latest('updated_at')->get();

        return view('admin.users.show', compact('user', 'progressStats', 'wordProgress'));
    }

    public function updateLevel(Request $request, User $user)
    {
        $request->validate([
            'level' => 'required|integer|min:1|max:10',
        ]);

        $user->update(['level' => $request->level]);

        return back()->with('success', 'User level updated successfully.');
    }
}
