<?php

namespace App\Services;
class ImageService
{
    public function saveImage($image, $path)
    {
        $imageName = time() . '.' . $image->extension();
        $image->storeAs($path, $imageName, ['disk' => 'public']);
        return $imageName;
    }
}
