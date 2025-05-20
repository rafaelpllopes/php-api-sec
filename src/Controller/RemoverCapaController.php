<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;

class RemoverCapaController implements Controller
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

        $success = $this->videoRepository->removeCape($id);
        if ($success === false) {
            $this->sendError('Erro ao remover a capa');
            header('Location: /');
        } else {
            $this->sendError('Capa removida com sucesso');
            header('Location: /');
        }

    }
}
