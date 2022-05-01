<?php

namespace App\Http\Services;

use Intervention\Image\ImageManager;

class ImageUpload {
    public static function UploadAndFitImage($file, $path, $name, $width, $height) {
        $path = trim($path, '\/') . '/';
        $name = trim($name, '\/') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!is_dir($path))
            if (!mkdir($path, 0777, true)) {
                echo '<div><small class="text-danger"> Operation Failed </small></div>';
                die('Image Resize : Failed to create DIRECTORY');
            }
        is_writable($path);
        $manager = new ImageManager(['driver' => 'GD']);
        $image = $manager->make($file['tmp_name'])->fit($width, $height);
        $image->save($path . $name);
        return '/' . $path . $name;
    }
}