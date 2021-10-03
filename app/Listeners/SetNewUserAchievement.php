<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// Models
use App\Models\Achievement;

class SetNewUserAchievement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AchievementUnlocked  $event
     * @return array
     */
    public function handle(AchievementUnlocked $event)
    {
        Achievement::updateOrCreate([
            'user_id' => $event->user->id,
            'achievement_name' => $event->achievement_name
        ]);
    }
}
