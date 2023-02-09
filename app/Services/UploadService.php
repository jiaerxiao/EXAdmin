<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class UploadService
{
    public function image($file, $width = 1920, $heigh = 1080, $fit = Manipulations::FIT_CONTAIN)
    {
        $filePath =  $file->store('images/' . date('Ym'));
        $realPath = storage_path('app/' . $filePath);
        Image::load($realPath)->fit($fit, $width, $heigh)->save(); 
        return $realPath;
    }
}
