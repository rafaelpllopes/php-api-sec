<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;
use Alura\Mvc\Trait\SaveFile;

class NewVideoController implements Controller
{
    use SaveFile, FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->sendError('URL inválida');
            header('Location: /novo-video');
            return;
        }

        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            $this->sendError('Título não informado');
            header('Location: /novo-video');
            return;
        }

        $video = new Video($url, $titulo);

        $this->saveFile($video);

        $success = $this->videoRepository->add($video);
        if ($success === false) {
            $this->sendError('Erro ao salvar o vídeo');
            header('Location: /novo-video');
        } else {
            $this->sendError('Vídeo salvo com sucesso');
            header('Location: /');
        }
    }
}
