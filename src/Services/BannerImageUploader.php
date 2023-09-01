<?php

namespace Mp\Module\MpBanner\Services;

use PrestaShop\PrestaShop\Adapter\Image\Uploader\AbstractImageUploader;
use MpBanner;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BannerImageUploader extends AbstractImageUploader
{
    private const DEFAULT_EXTENSION = 'jpg';

    public function upload($sliderId, UploadedFile $imageFile): string
    {
        $this->checkImageIsAllowedForUpload($imageFile);

        $filename = $this->generateFilename($imageFile);

        $imageFile->move(MpBanner::getImagesDir(), $filename);

        return $filename;
    }

    private function generateFilename(UploadedFile $file): string
    {
        return str_replace('.', '', uniqid('', true)) . '.' . ($file->guessExtension() ?: self::DEFAULT_EXTENSION);
    }
}
