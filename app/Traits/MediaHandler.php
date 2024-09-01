<?php

namespace App\Traits;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Plank\Mediable\Facades\MediaUploader;
use Plank\Mediable\Media;

trait MediaHandler
{
    public function uploadAvatarImage($file): Media
    {
        return MediaUploader::fromSource($file)
            ->toDisk(config('filesystems.default'))
            ->toDirectory('bankbook')
            ->useHashForFilename()
            ->upload();
    }

    // public function uploadIdCardImage($file): Media
    // {
    //     return MediaUploader::fromSource($file)
    //         ->toDisk(config('filesystems.default'))
    //         ->toDirectory('IdCard')
    //         ->useHashForFilename()
    //         ->upload();
    // }
    public function uploadLanguageSvg($file): Media
    {
        return MediaUploader::fromSource($file)
            ->toDisk(config('filesystems.default'))
            ->toDirectory('svg')
            ->useHashForFilename()
            ->upload();
    }

}
