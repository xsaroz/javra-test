<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

// Models
use App\Models\User;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    public $badge_name, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($badge_name, User $user)
    {
        $this->badge_name = $badge_name;
        $this->user = $user;
    }
}
