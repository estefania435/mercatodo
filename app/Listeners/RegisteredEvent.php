<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class RegisteredEvent
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event): void
    {
        $event->user->roles()->sync([2]);
    }
}
