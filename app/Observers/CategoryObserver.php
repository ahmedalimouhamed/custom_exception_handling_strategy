<?php

namespace App\Observers;

use App\Models\Category;
use App\Events\MediableEntityChanged;

class CategoryObserver
{
    public function created(Category $category): void
    {
        event(new MediableEntityChanged($category, 'created'));
    }

    public function updated(Category $category): void
    {
        event(new MediableEntityChanged($category, 'updated'));
    }

    public function deleted(Category $category): void
    {
        event(new MediableEntityChanged($category, 'deleted'));
    }
}
