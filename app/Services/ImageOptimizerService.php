<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    public function uploadAndConvertToWebp(UploadedFile $file, string $folder = 'articles', int $quality = 82): string
    {
        $targetDirectory = is_dir(base_path('../public_html'))
            ? base_path('../public_html/uploads/'.$folder)
            : public_path('uploads/'.$folder);

        if (! file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $filename = Str::random(24).'.webp';
        $destinationPath = $targetDirectory.DIRECTORY_SEPARATOR.$filename;

        $sourcePath = $file->getRealPath();
        $mime = $file->getMimeType();

        $image = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
            'image/png' => @imagecreatefrompng($sourcePath),
            'image/webp' => @imagecreatefromwebp($sourcePath),
            'image/gif' => @imagecreatefromgif($sourcePath),
            default => null,
        };

        if ($image) {

            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);

            imagewebp($image, $destinationPath, $quality);
            imagedestroy($image);
        } else {

            $filename = Str::random(24).'.'.$file->getClientOriginalExtension();
            $file->move($targetDirectory, $filename);
        }

        return $folder.'/'.$filename;
    }
}
