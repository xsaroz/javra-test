<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     * The achievements of user
     */
    public function unlockedAchievement()
    {
        return $this->hasMany(Achievement::class, 'user_id', 'id')->select('achievement_name');
    }

    /**
     * Filter the names of unlocked achievement
     */
    public function unlockedAchievementNames()
    {
        $unlocked_achievements = $this->unlockedAchievement;
        return array_values(array_column($unlocked_achievements->toArray(), 'achievement_name'));
    }

    /**
     * @return array next available achievements 
     */
    public function nextAvailableAchievements()
    {
        $unlocked_achievements_array = $this->unlockedAchievementNames();

        $all_achievements = array_merge(Comment::ACHIEVEMENTS, Lesson::ACHIEVEMENTS);

        return array_values(array_diff($all_achievements, $unlocked_achievements_array));
    }

    /**
     * current badge of user
     * @return string
     */
    public function currentBadge()
    {
        $current_badge = Badge::whereUserId($this->id)->orderBy('id', 'desc')->first();

        return $current_badge ? $current_badge->badge_name : null;
    }
}
