<?php

namespace App\Http\Controllers;

use Plank\Mediable\Media;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaViewController extends Controller
{

    public function displayImage(Media $media)
    {
        return Storage::disk($media->disk)->download($media->getDiskPath());
    }

    public function showImage($filename)
    {
        if ($filename) {
            $media = Media::whereBasename($filename)->first();
            return $media ? Storage::disk($media->disk)->download($media->getDiskPath()) : null;
        }
        return null;
    }


}
