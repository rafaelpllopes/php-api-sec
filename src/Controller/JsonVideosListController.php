<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideosListController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = array_map(
            function (Video $video): array {
                return [
                    'id' => $video->id,
                    'url' => $video->url,
                    'title' => $video->title,
                    'image_path' => '/img/uploads/' . $video->getFilePath()
                ];
            },
            $this->videoRepository->all()
        );
        
        $json = json_encode($videoList);
        return new Response(200, [
            'Content-type:' => 'application/json'
        ], $json);
    }
}
