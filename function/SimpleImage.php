<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * SimpleImage - A class for simple image manipulation
 */
final class SimpleImage
{
    private $image;
    private int $imageType;

    public function load(string $filename): void
    {
        $imageInfo = getimagesize($filename);
        $this->imageType = $imageInfo[2];

        $this->image = match ($this->imageType) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($filename),
            IMAGETYPE_GIF => imagecreatefromgif($filename),
            IMAGETYPE_PNG => imagecreatefrompng($filename),
            default => throw new RuntimeException('Unsupported image type'),
        };
    }

    public function save(
        string $filename,
        int $imageType = IMAGETYPE_JPEG,
        int $compression = 75,
        ?int $permissions = null
    ): void {
        match ($imageType) {
            IMAGETYPE_JPEG => imagejpeg($this->image, $filename, $compression),
            IMAGETYPE_GIF => imagegif($this->image, $filename),
            IMAGETYPE_PNG => imagepng($this->image, $filename),
            default => throw new RuntimeException('Unsupported image type'),
        };

        if ($permissions !== null) {
            chmod($filename, $permissions);
        }
    }

    public function output(int $imageType = IMAGETYPE_JPEG): void
    {
        match ($imageType) {
            IMAGETYPE_JPEG => imagejpeg($this->image),
            IMAGETYPE_GIF => imagegif($this->image),
            IMAGETYPE_PNG => imagepng($this->image),
            default => throw new RuntimeException('Unsupported image type'),
        };
    }

    public function getWidth(): int
    {
        return imagesx($this->image);
    }

    public function getHeight(): int
    {
        return imagesy($this->image);
    }

    public function resizeToHeight(int $height): void
    {
        $ratio = $height / $this->getHeight();
        $width = (int) ($this->getWidth() * $ratio);
        $this->resize($width, $height);
    }

    public function resizeToWidth(int $width): void
    {
        $ratio = $width / $this->getWidth();
        $height = (int) ($this->getHeight() * $ratio);
        $this->resize($width, $height);
    }

    public function scale(int|float $scale): void
    {
        $width = (int) ($this->getWidth() * $scale / 100);
        $height = (int) ($this->getHeight() * $scale / 100);
        $this->resize($width, $height);
    }

    public function resize(int $width, int $height): void
    {
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $newImage,
            $this->image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $this->getWidth(),
            $this->getHeight()
        );
        $this->image = $newImage;
    }
}
