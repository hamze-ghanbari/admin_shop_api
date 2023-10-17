<?php

namespace App\Http\Services\ImageService;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageToolsService
{

    protected $image;
    protected $exclusiveDirectory;
    protected $imageDirectory;
    protected $imageName;
    protected $imageFormat;
    protected $finalImageDirectory;
    protected $finalImageName;

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    public function getImageDirectory()
    {
        return $this->imageDirectory;
    }

    public function setImageDirectory($imageDirectory)
    {
        $this->imageDirectory = trim($imageDirectory, DIRECTORY_SEPARATOR);
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function setCurrentImageName()
    {
        return !empty($this->image) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
    }

    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    public function setImageFormat($imageFormat)
    {
        $this->imageFormat = $imageFormat;
    }

    public function getFinalImageDirectory()
    {
        return $this->finalImageDirectory;
    }

    public function setFinalImageDirectory($finalImageDirectory)
    {
        $this->finalImageDirectory = $finalImageDirectory;
    }

    public function getFinalImageName()
    {
        return $this->finalImageName;
    }

    public function setFinalImageName($finalImageName)
    {
        $this->finalImageName = $finalImageName;
    }


    protected function checkDirectory($imageDirectory)
    {
        if (!file_exists($imageDirectory)) {
            File::makeDirectory($imageDirectory, 0777, true, true);
//            mkdir($imageDirectory, 0777, true);
        }
    }

    public function getImageAddress()
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }

    protected function provider()
    {
        $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
        $this->getImageName() ?? $this->setImageName(time());
        $this->getImageFormat() ?? $this->setImageFormat($this->image->extension());

        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR .
            $this->getImageDirectory();

        $this->setFinalImageDirectory($finalImageDirectory);

        $this->setFinalImageName($this->getImageName() . '.' . $this->getImageFormat());

        $this->checkDirectory($this->getFinalImageDirectory());
    }

    public function setBase64NameImage($image): array
    {
        $extension = explode(';', explode('/', ($image))[1])[0];
        $search = "data:image/$extension;base64,";
        $image = str_replace($search, '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(20);
        return [
            'image' => $image,
            'imageName' => $imageName,
            'extension' => $extension
        ];
    }

}
