<?php

namespace App\Observers;

use App\Models\Admin;
use App\Events\MediableEntityChanged;

class AdminObserver
{
    public function created(Admin $admin): void
    {
        event(new MediableEntityChanged($admin, 'created'));
    }

    public function updated(Admin $admin): void
    {
        event(new MediableEntityChanged($admin, 'updated'));
    }

    public function deleted(Admin $admin): void
    {
        event(new MediableEntityChanged($admin, 'deleted'));
    }
}
