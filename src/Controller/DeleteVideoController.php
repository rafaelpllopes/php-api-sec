<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;

class DeleteVideoController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->sendError('ID inválida');
            header('Location: /');
            return;
        }

        $success = $this->videoRepository->remove($id);
        if ($success === false) {
            $this->sendError('Erro ao remover um vídeo');
            header('Location: /');
        } else {
            $this->sendError('Vídeo removido com sucesso');
            header('Location: /');
        }

    }
}
