<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    CONST ACHIEVEMENTS = [
        'First Lesson Watched',
        '5 Lessons Watched',
        '10 Lessons Watched',
        '25 Lessons Watched',
        '50 Lessons Watched',
    ];
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    public static function userAchievementNameByLessons ($number_of_lessons) 
    {
        $achievements = self::ACHIEVEMENTS;

        switch ($number_of_lessons) {
            case 1:
                $achievement_name = $achievements[0];
                break;
            case 5:
                $achievement_name = $achievements[1];
                break;
            case 10:
                $achievement_name = $achievements[2];
                break;
            case 25:
                $achievement_name = $achievements[3];
                break;
            case 50:
                $achievement_name = $achievements[4];
                break;
            default:
                $achievement_name = null;
                break;
        }

        return $achievement_name;
    }
}
