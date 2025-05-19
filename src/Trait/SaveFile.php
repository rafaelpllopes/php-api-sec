<?php

namespace Alura\Mvc\Trait;

use Alura\Mvc\Entity\Video;

trait SaveFile
{
    public function saveFile(Video $video) : void {

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
            $originalNameSafe = pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            if (str_starts_with($mimeType, 'image/')) {
                $extension = pathinfo($originalNameSafe, PATHINFO_EXTENSION);
                $imageName = uniqid('upload_', true) . '.' . $extension;
        
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $imageName
                );
                /**
                 * @var Video $video
                 */
                $video->setFilePath($imageName);
            }
        }
    }
}