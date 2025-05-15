<?php

namespace App\Listeners;

use App\Helpers\MediaHelper;
use App\Events\MediableEntityChanged;

class SyncMediaForEntity
{
    /**
     * Handle the event.
     */
    public function handle(MediableEntityChanged $event): void
    {
        $model = $event->model;
        $action = $event->action;

        if($action === 'created' || $action === 'updated') {
            MediaHelper::sync($model);
        }else{
            MediaHelper::detach($model);
        }
    }
}
