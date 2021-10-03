<?php

namespace App\Listeners;

use DB;
use App\Events\LessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;

// Models
use App\Models\Badge;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Achievement;

class CountUserLesson
{
    /**
     * Handle the event.
     *
     * @param  LessonWatched  $event
     * @return array
     */
    public function handle(LessonWatched $event)
    {
        $lesson = $event->lesson;
        $user = $event->user;

        // count number of lessons of user
        $count_user_watched_lesson = DB::table('lesson_user')->whereUserId($user->id)->count();
        // give achievement names according to lessons watched
        $achievement_name = Lesson::userAchievementNameByLessons($count_user_watched_lesson);

        if ($achievement_name) {
            // call to an event for new achievements
            AchievementUnlocked::dispatch($achievement_name, $user);
        }

        $total_achievements = Achievement::where('user_id', $user->id)->count();

        $badge_name = Badge::userBadgeNameByAchievements($total_achievements);

        if ($badge_name) {
            BadgeUnlocked::dispatch($badge_name, $user);
        }
    }
}
