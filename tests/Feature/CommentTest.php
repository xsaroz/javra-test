<?php

namespace Tests\Feature;

use DB;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use App\Models\Comment;
use App\Events\CommentWritten;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function check_achievement_and_badge_for_first_comment_written()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create(['user_id' => $user->id]);

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 1);

        // trigger event
        CommentWritten::dispatch($comment);

        // the badges and achievements for first comment written should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 1);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id','desc')->first();

        // Achievement should be equal to First Comment written
        $this->assertSame($achievement->achievement_name, Comment::ACHIEVEMENTS[0]);

        $badge = DB::table('badges')->where('user_id', $user->id)->latest()->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_three_comment_written()
    {
        $user = User::factory()->create();

        for ($i=0; $i < 3; $i++) { 
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 3);

        // the badges and achievements for first comment written should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 2);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id','desc')->first();

        // Achievement should be equal to First Comment written
        $this->assertSame($achievement->achievement_name, Comment::ACHIEVEMENTS[1]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_five_comment_written()
    {
        $user = User::factory()->create();

        for ($i=0; $i < 5; $i++) { 
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 5);

        // the badges and achievements for first comment written should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 1);
        $this->assertDatabaseCount('achievements', 3);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id','desc')->first();

        // Achievement should be equal to First Comment written
        $this->assertSame($achievement->achievement_name, Comment::ACHIEVEMENTS[2]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[0]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_ten_comment_written()
    {
        $user = User::factory()->create();

        for ($i=0; $i < 10; $i++) { 
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 10);

        // the badges and achievements for first comment written should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 2);
        $this->assertDatabaseCount('achievements', 4);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id','desc')->first();

        // Achievement should be equal to First Comment written
        $this->assertSame($achievement->achievement_name, Comment::ACHIEVEMENTS[3]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[1]);
    }

    /**
     * @test
     */
    public function check_achievement_and_badge_for_twenty_comment_written()
    {
        $user = User::factory()->create();

        for ($i=0; $i < 20; $i++) { 
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // there should be only one entry for comment written by user
        $this->assertDatabaseCount('comments', 20);
        // the badges and achievements for first comment written should be entered in database whose row count is 1
        $this->assertDatabaseCount('badges', 2);
        $this->assertDatabaseCount('achievements', 5);

        $achievement = DB::table('achievements')->where('user_id', $user->id)->orderBy('id','desc')->first();

        // Achievement should be equal to First Comment written
        $this->assertSame($achievement->achievement_name, Comment::ACHIEVEMENTS[4]);

        $badge = DB::table('badges')->where('user_id', $user->id)->orderBy('id', 'desc')->first();

        // Badge should be equal to Beginner
        $this->assertSame($badge->badge_name, Badge::BADGES[1]);
    }
}
