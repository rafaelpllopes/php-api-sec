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

class EditVideoController implements RequestHandlerInterface
{
    use SaveFile, FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getQueryParams()['id'];

        $queryParams = $request->getParsedBody();
        $url = filter_var($queryParams['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($queryParams['titulo']);
        
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->sendError('ID inválida');
            return new Response(400, [
                'Location' => '/editar-video?id=' . $id
            ]);
        }

        if ($url === false) {
            $this->sendError('URL inválida');
            return new Response(400, [
                'Location' => '/editar-video'
            ]);
        }
        if ($titulo === false) {
            $this->sendError('Titulo não informado');
            return new Response(400, [
                'Location' => '/editar-video'
            ]);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $this->saveFile($video, $request);

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->sendError('Erro ao salvar o video');
            return new Response(400, [
                'Location' => '/editar-video'
            ]);
        } else {
            $this->sendError('Vídeo salvo com sucesso');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}