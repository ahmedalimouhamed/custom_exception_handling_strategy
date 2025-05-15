<?php

namespace App\Observers;

use App\Models\Fournisseur;
use App\Events\MediableEntityChanged;

class FournisseurObserver
{
    public function created(Fournisseur $fournisseur): void
    {
        event(new MediableEntityChanged($fournisseur, 'created'));
    }

    public function updated(Fournisseur $fournisseur): void
    {
        event(new MediableEntityChanged($fournisseur, 'updated'));
    }

    public function deleted(Fournisseur $fournisseur): void
    {
        event(new MediableEntityChanged($fournisseur, 'deleted'));
    }
}
