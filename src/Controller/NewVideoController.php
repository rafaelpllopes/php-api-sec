<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Trait\FlashMessageTrait;
use Alura\Mvc\Trait\SaveFile;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface
{
    use SaveFile, FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();
        $url = filter_var($queryParams['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($queryParams['titulo']);

        if ($url === false) {
            $this->sendError('URL inválida');
            return new Response(400, [
                'Location' => '/novo-video'
            ]);
        }

        if ($titulo === false) {
            $this->sendError('Título não informado');
            return new Response(400, [
                'Location' => '/novo-video'
            ]);
        }

        $video = new Video($url, $titulo);

        $this->saveFile($video, $request);

        $success = $this->videoRepository->add($video);
        if ($success === false) {
            $this->sendError('Erro ao salvar o vídeo');
            return new Response(400, [
                'Location' => '/novo-video'
            ]);
        } else {
            $this->sendError('Vídeo salvo com sucesso');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}
