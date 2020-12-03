<?php

namespace App\Listeners;

use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginSuccessful
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
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        /*$user = $event->user;
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->last_login_ip = $this->request->ip();
        $user->save();*/

        $data = [
            'user_type' => (new \ReflectionClass(auth()->user()))->getName(),//class_basename(auth()->user()),
            'auditable_id' => auth()->user()->id,
            'auditable_type' => "Logged In",
            'event'      => "Logged In",
            'url'        => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id'          => auth()->user()->id,
        ];

        //create audit trail data
        $details = Audit::create($data);
    }
}
