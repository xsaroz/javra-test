<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    CONST BADGES = [
        'Beginner',
        'Intermediate',
        'Advanced',
        'Master'
    ];

    protected $fillable = [
        'badge_name',
        'user_id'
    ];

    /**
     * get badge name by total no. of user's achievements
     */
    public static function userBadgeNameByAchievements($number_of_achievements)
    {
        $badges = self::BADGES;

        switch ($number_of_achievements) {
            // Since there will always be one entry for watch or comment, the 0 case is removed
            case 1:
                $badge_name = $badges[0];
                break;
            case 4:
                $badge_name = $badges[1];
                break;
            case 8:
                $badge_name = $badges[2];
                break;
            case 10: 
                $badge_name = $badges[3];
                break;
            default:
                $badge_name = null;
                break;
        }

        return $badge_name;
    }
}
