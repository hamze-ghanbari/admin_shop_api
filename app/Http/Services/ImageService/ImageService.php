<?php

namespace App\Http\Services\ImageService;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageService extends ImageToolsService
{
    public function base64Save($image)
    {
        $imageData = $this->setBase64NameImage($image);
        $this->setImageFormat($imageData['extension']);
        $this->setImageName($imageData['imageName']);
        $this->provider();
        $result = Image::make($image)->save($this->getImageAddress(), null, $this->getImageFormat());

        return $result ? $this->getImageAddress() : false;
    }

    public function save($image)
    {
        $this->setImage($image);

        $this->provider();

        $result = Image::make($image->getRealPath())->save($this->getImageAddress(), null, $this->getImageFormat());

        return $result ? $this->getImageAddress() : false;

    }

    public function fitAndSave($image, $width, $height)
    {
        $this->setImage($image);

        $this->provider();

        $result = Image::make($image->getRealPath())->fit($width, $height)->save($this->getImageAddress(), null, $this->getImageFormat());

        return $result ? $this->getImageAddress() : false;

    }

    public function createIndexAndSave($image)
    {
        $imageSizes = Config::get('image.index-image-sizes');

        $this->setImage($image);

        $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->setImageDirectory($this->getImageDirectory() . DIRECTORY_SEPARATOR . time());

        $this->getImageName() ?? $this->setImageName(time());
        $imageName = $this->getImageName();

        $indexArray = [];

        foreach ($imageSizes as $sizeAlias => $imageSize) {
            $currentImageName = $imageName . '_' . $sizeAlias;
            $this->setImageName($currentImageName);

            $this->provider();

            $result = Image::make($image->getRealPath())->fit($imageSize['width'], $imageSize['height'])->save($this->getImageAddress(), null, $this->getImageFormat());

            if ($result) {
                $indexArray[$sizeAlias] = $this->getImageAddress();
            } else {
                return false;
            }
        }

        $images['indexArray'] = $indexArray;
        $images['directory'] = $this->getFinalImageDirectory();
        $images['currentImage'] = Config::get('image.default-current-index-image');

        return $images;

    }

    public function deleteImage($imagePath)
    {
        if (file_exists($imagePath)) {
            unlink($imagePath);
            $dirName = dirname($imagePath);
        if (File::allFiles($dirName) === []) {
            File::deleteDirectory($dirName);
        }
        }
    }

    public function deleteIndex($images)
    {
        $directory = public_path($images['directory']);
        $this->deleteDirectoryAndFiles($directory);
    }

    public function deleteDirectoryAndFiles($directory)
    {
        if (!is_dir($directory)) {
            return false;
        }

        $files = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDirectoryAndFiles($files);
            } else {
                unlink($file);
            }
        }

        return rmdir($directory);

    }

}
