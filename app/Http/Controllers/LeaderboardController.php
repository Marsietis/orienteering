<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::orderBy('points', 'desc')
            ->where('points', '>', 0)
            ->orderBy('updated_at')
            ->get();

        return Inertia::render('Leaderboard', [
            'users' => $users
        ]);
    }
}
