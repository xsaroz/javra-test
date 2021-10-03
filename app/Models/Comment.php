<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    CONST ACHIEVEMENTS = [
        'First Comment Written',
        '3 Comments Written',
        '5 Comments Written',
        '10 Comment Written',
        '20 Comment Written',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id'
    ];

    /**
     * Get the user that wrote the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get users achievement name by count of comments
     */
    public static function userAchievementNameByComments($number_of_comments)
    {
        $achievements = self::ACHIEVEMENTS;

        switch ($number_of_comments) {
            case 1:
                $achievement_name = $achievements[0];
                break;
            case 3:
                $achievement_name = $achievements[1];
                break;
            case 5:
                $achievement_name = $achievements[2];
                break;
            case 10:
                $achievement_name = $achievements[3];
                break;
            case 20:
                $achievement_name = $achievements[4];
                break;
            default:
                $achievement_name = null;
                break;
        }

        return $achievement_name;
    }
}
