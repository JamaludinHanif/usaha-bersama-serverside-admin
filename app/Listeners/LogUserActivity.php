<?php

namespace App\Listeners;

use App\Models\LogActivity;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */

    public function handle($event)
    {
        $action = $event instanceof Login ? 'login' : 'logout';

        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => $action,
        ]);
    }
}
