<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;


// Models
use App\Models\User;

class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    public $achievement_name, $user;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($achievement_name, User $user)
    {
        $this->achievement_name = $achievement_name;
        $this->user = $user;
    }
}
