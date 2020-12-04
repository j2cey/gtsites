<?php

namespace App\Listeners;

use App\Models\User;
use App\Mail\WorkflowStepNext;
use Illuminate\Support\Facades\Mail;
use App\Events\WorkflowStepCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNextWorkflowStepEmail
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
     * @param  WorkflowStepCompleted  $event
     * @return void
     */
    public function handle(WorkflowStepCompleted $event)
    {
        $this->notifierActeurs($event->nextStep);
    }

    private function notifierActeurs($step) {
        //$actors_ids = DB::table('model_has_roles')->where('model_type', 'App\User')->pluck('model_id')->toArray();
        //$actors = User::whereIn('id', $actors_ids)->get();
        $actors = User::role($step->profile->name)->get();
        if ($actors) {
            foreach ($actors as $actor) {
                if ($actor->email) {
                    if (filter_var($actor->email, FILTER_VALIDATE_EMAIL)) {
                        Mail::to($actor->email)
                            ->send(new WorkflowStepNext($step));
                    }
                }
            }
        }
    }
}
