<?php

namespace Alura\Mvc\Trait;

use Alura\Mvc\Entity\Video;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

trait SaveFile
{
    public function saveFile(Video $video, ServerRequestInterface $request) : void {

        $files = $request->getUploadedFiles();
        /**
        * @var UploadedFileInterface $uploadedImage
        */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
                
            $originalNameSafe = pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $extension = pathinfo($originalNameSafe, PATHINFO_EXTENSION);
                $imageName = uniqid('upload_', true) . '.' . $extension;

                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $imageName);
        
                /**
                 * @var Video $video
                 */
                $video->setFilePath($imageName);
            }
        }
    }
}