<?php

namespace Tests\Feature;

use DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Events\LessonWatched;

use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function check_achievement_and_badge_for_first_lesson_watched()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 1);

        $response = LessonWatched::dispatch($lesson, $user);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 1);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->latest()->first();

        // Achievement should be equal to First Lesson Watched
        $this->assertSame($achievement->achievement_name, Lesson::ACHIEVEMENTS[0]);

        $badge = DB::table('badges')->where('user_id', $user->id)->latest()->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_five_lessons_watched ()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(5)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 5);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 2);

        // get list of achievements in desc order. for some reasons latest() is not working
        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Achievement should be equal to First Lesson Watched
        $this->assertSame($achievement->achievement_name, Lesson::ACHIEVEMENTS[1]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner since there are only two achievements
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_ten_lessons_watched ()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(10)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 10);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 3);

        // get list of achievements in desc order. for some reasons latest() is not working
        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Achievement should be equal to First Lesson Watched
        $this->assertSame($achievement->achievement_name, Lesson::ACHIEVEMENTS[2]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner since there are only two achievements
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_twentyfive_lessons_watched ()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(25)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 25);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 2);
        $this->assertDatabaseCount('achievements', 4);

        // get list of achievements in desc order. for some reasons latest() is not working
        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Achievement should be equal to First Lesson Watched
        $this->assertSame($achievement->achievement_name, Lesson::ACHIEVEMENTS[3]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner since there are only two achievements
        $this->assertSame($badge->badge_name, Badge::BADGES[1]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_fifty_lessons_watched ()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(50)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 50);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 2);
        $this->assertDatabaseCount('achievements', 5);

        // get list of achievements in desc order. for some reasons latest() is not working
        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Achievement should be equal to First Lesson Watched
        $this->assertSame($achievement->achievement_name, Lesson::ACHIEVEMENTS[4]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner since there are only two achievements
        $this->assertSame($badge->badge_name, Badge::BADGES[1]);
    }
}
