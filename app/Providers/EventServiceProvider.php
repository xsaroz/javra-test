<?php

namespace App\Providers;

use App\Events\LessonWatched;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Listeners\CountUserLesson;
use App\Listeners\SetNewUserBadge;
use App\Events\AchievementUnlocked;
use App\Listeners\CountUserComment;
use Illuminate\Support\Facades\Event;
use App\Listeners\SetNewUserAchievement;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            CountUserComment::class,
        ],
        LessonWatched::class => [
            CountUserLesson::class,
        ],
        AchievementUnlocked::class => [
            SetNewUserAchievement::class,
        ],
        BadgeUnlocked::class => [
            SetNewUserBadge::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
