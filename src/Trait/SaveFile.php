<?php

namespace Alura\Mvc\Trait;

use Alura\Mvc\Entity\Video;

trait SaveFile
{
    public function saveFile(Video $video) : void {

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
            $originalName = $_FILES['image']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
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