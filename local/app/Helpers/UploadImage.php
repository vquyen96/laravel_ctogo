<?php

namespace App\Helpers;


class UploadImage
{
    protected $image;
    protected $filename;
    protected $size;
    protected $extension;
    protected $uploadPath;

    protected $max_size;
    protected $new_width;
    protected $new_height;
    protected $destination_image;

    public function __construct($input)
    {
        $this->image = $input;
        $this->size = getimagesize($this->image);
        $this->extension = $this->image->extension();
        $this->filename = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999)) . "." . $this->extension;
        $this->uploadPath = storage_path('app/upload');
    }

    public function handleUploadAndResize($max_size)
    {
        $this->max_size = $max_size;
        $this->handleResize();
        $this->handleUpload();
        return $this->filename;
    }

    public function handleUpload()
    {
        $this->image->storeAs('upload', $this->filename);
        return $this->filename;
    }

    public function handleResize()
    {
        $this->createBlankImage($this->max_size);

        $this->saveResizedImage();

        return 'resized-'.$this->filename;
    }

    protected function saveResizedImage()
    {
        $path = $this->uploadPath.'/resized-'.$this->filename;

        switch ($this->extension) {
            case 'jpeg':
                $orig_image = imagecreatefromjpeg($this->image);
                $this->copyResampled($orig_image);
                imagejpeg($this->destination_image, $path);
                break;

            case 'jpg':
                $orig_image = imagecreatefromjpeg($this->image);
                $this->copyResampled($orig_image);
                imagejpeg($this->destination_image, $path);
                break;

            case 'png':
                $orig_image = imagecreatefrompng($this->image);
                $this->copyResampled($orig_image);
                imagepng($this->destination_image, $path);
                break;

            case 'gif':
                $orig_image = imagecreatefromgif($this->image);
                $this->copyResampled($orig_image);
                imagegif($this->destination_image, $path);
                break;
        }
    }

    protected function copyResampled($orig_image)
    {
        return imagecopyresampled($this->destination_image, $orig_image, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->size[0], $this->size[1]);
    }

    protected function createBlankImage($max_size)
    {
        if ( $this->isPortrait() ) {
            $this->new_height = $max_size;
            $this->new_width = $this->new_height * $this->getRatio();
        } else {
            $this->new_width = $max_size;
            $this->new_height = $this->new_width / $this->getRatio();
        }
        $this->destination_image = imagecreatetruecolor($this->new_width, $this->new_height);
    }

    public function isPortrait()
    {
        if ($this->getRatio() <= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRatio()
    {
        $width = $this->size[0] ;
        $height = $this->size[1] ;
        return $width / $height;
    }
}