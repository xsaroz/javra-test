<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $badges = Badge::BADGES;
        // get achievement names from relation with users table
        $unlocked_achievement_names = $user->unlockedAchievementNames();

        $next_available_achievements = $user->nextAvailableAchievements();

        $current_badge = $user->currentBadge();

        $next_badge_position = array_search($current_badge, $badges) + 1;

        $next_badge = $current_badge ? $badges[$next_badge_position] : null;
        
        return response()->json([
            'unlocked_achievements' => $unlocked_achievement_names,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaing_to_unlock_next_badge' => array_splice($badges, $next_badge_position)
        ]);
    }
}
