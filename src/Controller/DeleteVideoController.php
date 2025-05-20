<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->sendError('ID inválida');
            return new Response(400, [
                'Location' => '/'
            ]);
        }

        $success = $this->videoRepository->remove($id);
        if ($success === false) {
            $this->sendError('Erro ao remover um vídeo');
            return new Response(400, [
                'Location' => '/'
            ]);
        } else {
            $this->sendError('Vídeo removido com sucesso');
            return new Response(200, [
                'Location' => '/'
            ]);
        }

    }
}
