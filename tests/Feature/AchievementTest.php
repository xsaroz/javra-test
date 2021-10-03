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

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * get the structure for user achievements
     * @test
     */
    public function get_user_achievement_information()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory(50)->create();

        foreach ($lessons as $key => $lesson) {
            DB::table('lesson_user')->insert(['user_id' => $user->id, 'lesson_id' => $lesson->id]);
            // the LessonWatched event runs for every lessons created
            $response = LessonWatched::dispatch($lesson, $user);
        }

        // writing ten comments that will give 4 achievements
        for ($i=0; $i < 10; $i++) {
            // create comment for $user
            $comment = Comment::factory()->create(['user_id' => $user->id]);
            // trigger event
            CommentWritten::dispatch($comment);
        }

        // call for route
        $response = $this->call('GET', '/users/' . $user->id . '/achievements');

        $responseContent = json_decode($response->getContent(), true);

        // the response structure should be mainted as following
        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaing_to_unlock_next_badge' 
        ]);

        $this->assertSame(count($responseContent['unlocked_achievements']), 9);
        // current badge
        $this->assertSame($responseContent['current_badge'], Badge::BADGES[2]);
        // next badge should be one step higher than current badge
        $this->assertSame($responseContent['next_badge'], Badge::BADGES[3]);

        $response->assertStatus(200);
    }
}
