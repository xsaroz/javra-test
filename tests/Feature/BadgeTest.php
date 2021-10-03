<?php

namespace Tests\Feature;

use DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\Achievement;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test for two achievements - the badge name will be beginner
     * @test
     */
    public function badge_for_beginner()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 1);

        // trigger event for lesson
        $response = LessonWatched::dispatch($lesson, $user);

        $comment = Comment::factory()->create(['user_id' => $user->id]);

        // trigger event for comment
        CommentWritten::dispatch($comment);

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 1);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 2);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * Test for four achievements - the badge name will be beginner
     * @test
     */
    public function badge_for_intermediate()
    {
        $user = User::factory()->create();

        // write first lessson that will give one achievement
        $lesson = Lesson::factory()->create();

        DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);

        // there should be only one entry for lesson learned by user
        $this->assertDatabaseCount('lesson_user', 1);

        // trigger event for lesson
        $response = LessonWatched::dispatch($lesson, $user);

        // writing ten comments that will give 3 achievements
        for ($i=0; $i < 5; $i++) { 
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 5);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 2);
        $this->assertDatabaseCount('achievements', 4);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[1]);
    }

    /**
     * Test for 8 achievements - the badge name will be advanced
     * @test
     */
    public function badge_for_advanced()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(25)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user which is equal to 4 achievements
        $this->assertDatabaseCount('lesson_user', 25);

        // writing ten comments that will give 4 achievements
        for ($i=0; $i < 10; $i++) {
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 10);

        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 3);
        $this->assertDatabaseCount('achievements', 8);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[2]);
    }

    /**
     * Test for 8 achievements - the badge name will be advanced
     * @test
     */
    public function badge_for_master()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(50)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // there should be only one entry for lesson learned by user which is equal to 4 achievements
        $this->assertDatabaseCount('lesson_user', 50);

        // writing ten comments that will give 4 achievements
        for ($i=0; $i < 20; $i++) {
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 20);
        // the badges and achievements for first lesson watch should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 4);
        $this->assertDatabaseCount('achievements', 10);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[3]);
    }
}
