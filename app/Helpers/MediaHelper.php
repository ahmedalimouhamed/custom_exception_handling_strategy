<?php

namespace App\Helpers;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    public static function sync(Model $model):void
    {
        if(request()->hasFile('image')){
            $file = request()->file('image');
            $path = $file->store('medias');

            //$file->move(public_path('medias'), $path);

            Storage::disk('public')->put(
                $path,
                file_get_contents($file->getRealPath())
            );
            
            $model->media()->create([
                'url' => $path,
                'type' => 'image',
            ]);

            Log::info("Media created for model #{$model->id} with path {$path}");
        }
    }

    public static function detach(Model $model):void
    {
        foreach($model->media as $media){
            Storage::delete($media->url);
            $media->delete();

            Log::info("Media deleted for model #{$model->id} with path {$media->url}");
        }
    }
}
