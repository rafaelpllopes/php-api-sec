<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;
use Alura\Mvc\Trait\SaveFile;

class EditVideoController implements Controller
{
    use SaveFile, FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->sendError('ID inválida');
            header('Location: /editar-video');
            return;
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->sendError('URL inválida');
            header('Location: /editar-video');
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            $this->sendError('Titulo não informado');
            header('Location: /editar-video');
            return;
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $this->saveFile($video);

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->sendError('Erro ao salvar o video');
            header('Location: /editar-video');
        } else {
            $this->sendError('Vídeo salvo com sucesso');
            header('Location: /');
        }
    }
}