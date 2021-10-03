<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// Models
use App\Models\User;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Achievement;

class CountUserComment
{
    /**
     * Handle the event.
     *
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $comment = $event->comment;

        // take user id from comment
        $userId = $comment->user_id;

        // count number of comments of user
        $count_user_comments = Comment::where('user_id', $userId)->count();

        // give achievement names according to comments written
        $achievement_name = Comment::userAchievementNameByComments($count_user_comments);
        // Find User
        $user = User::find($userId);

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
