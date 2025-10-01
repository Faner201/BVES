<?php
namespace App\Controller;

use App\Module\ConnectionInterface;
use App\Module\Producer\Producer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DataAcceptanceController extends AbstractController
{
    /**
     * @Route("/processing", name="app_processing", methods={"GET", "POST"})
     */
    public function processing(Request $request, ConnectionInterface $connection): Response
    {

//        $data = json_decode(json_decode($request->getContent()), true);
        $data = $request->getContent();
        $queue = 'task';

        $producer = new Producer($connection);

        $producer->sending($data, $queue);
        $producer->closure();

        return new Response(
            '<html><body>Информация принята!</body></html>',
            Response::HTTP_OK
        );
    }

}